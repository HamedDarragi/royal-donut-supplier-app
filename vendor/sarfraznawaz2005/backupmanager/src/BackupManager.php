<?php

namespace Sarfraznawaz2005\BackupManager;

use DB;
use App;
use Log;
use Storage;
use Carbon\Carbon;
use App\Models\DatabaseInformation;

class BackupManager
{
    public $i = 1;
    protected $disk = '';
    protected $backupPath;
    protected $backupSuffix;
    protected $fBackupName;
    protected $dBackupName;
    protected $fileVerifyName = 'backup-verify';

    protected $input_db_name;

    /**
     * BackupManager constructor.
     */
    public function __construct()
    {
        $num = time();
        $this->disk = config('backupmanager.backups.disk');
        $this->backupPath = config('backupmanager.backups.backup_path') . DIRECTORY_SEPARATOR;
        $this->backupSuffix = strtolower(config('backupmanager.backups.backup_file_date_suffix'));
        $this->fBackupName = "f_$this->backupSuffix.tar";
        $this->dBackupName = "d_$this->backupSuffix$num.gz";

        $this->mysql = config('backupmanager.paths.mysql', 'mysql');
        $this->mysqldump = config('backupmanager.paths.mysqldump', 'mysqldump');
        $this->tar = config('backupmanager.paths.tar', 'tar');
        $this->zcat = config('backupmanager.paths.zcat', 'zcat');

        $this->input_db_name = null;

        Storage::disk($this->disk)->makeDirectory($this->backupPath);
        // $i++;
    }

    /**
     * Gets list of backups
     */
    public function getBackups()
    {
        $files = Storage::disk($this->disk)->listContents($this->backupPath);

        $filesData = [];

        foreach ($files as $index => $file) {
            $filesData[] = [
                'name' => $file['basename'],
                'size_raw' => $file['size'],
                'size' => $this->formatSizeUnits($file['size']),
                'type' => $file['basename'][0] === 'd' ? 'Database' : 'Files',
                'date' => date('M d Y', $this->getFileTimeStamp($file))
            ];
        }

        // sort by date
        $filesData = collect($filesData)->sortByDesc(function ($temp, $key) {
            return Carbon::parse($temp['date'])->getTimestamp();
        })->all();

        return array_values($filesData);
    }

    /**
     * Creates new backup
     *
     * @return array
     */
    public function createBackup($a, $b)
    {
        // dd($a . " BBBBb " . $b);
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        // $this->backupFiles();
        $this->input_db_name = $b;
        $this->dBackupName = "$b.gz";
        $this->backupDatabase();
        // $this->deleteOldBackups();

        return $this->getBackupStatus();
    }

    /**
     * Restores database|fiels backups.
     * @param array $files
     * @return array|bool
     */
    public function restoreBackups($file)
    {
        // dd($file[0]);
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $restoreStatus = [];
        // foreach ($files as $file) {

        $isFiles = $file[0] === 'f';
        // dump($isFiles);
        if ($isFiles) {
            $this->restoreFiles($file);
        } else {
            $this->restoreDatabase($file);
        }

        $restoreStatus[] = $this->getRestoreStatus($isFiles);
        // }

        // dd('test');
        return $restoreStatus;
    }

    public function deleteBackups($file)
    {
        $status = false;

        // foreach ($files as $file) {
        $status = Storage::disk($this->disk)->delete($this->backupPath . $file);
        // }

        return $status;
    }

    /**
     * Backup files
     */
    public function updateDb($db, $edit_db)
    {
        // dump($this->backupPath);
        // dump("EDIT".$edit_db);
        // dd($db);
        if($db != $edit_db){
             if (Storage::disk($this->disk)->exists($this->backupPath . $db)) {
            Storage::disk($this->disk)->move($this->backupPath . $db, $this->backupPath . $edit_db);
            return "y";
            } else {
                return "n";
            }
        }
        else{
            return "y";
        }
    }
    protected function backupFiles()
    {
        if (config('backupmanager.backups.files.enable')) {

            // delete previous backup for same date
            if (Storage::disk($this->disk)->exists($this->backupPath . $this->fBackupName)) {
                Storage::disk($this->disk)->delete($this->backupPath . $this->fBackupName);
            }

            # this will be used to verify later if restore was successful
            file_put_contents(base_path($this->fileVerifyName), 'backup');

            $itemsToBackup = config('backupmanager.backups.files.folders');

            $itemsToBackup = array_map(
                function ($str) {
                    $pathPrefix = dirname(getcwd());

                    if (App::runningInConsole()) {
                        $pathPrefix = getcwd();
                    }

                    return str_replace(array($pathPrefix, '/', '\\'), '', $str);
                },
                $itemsToBackup
            );

            // also add our backup verifier
            $itemsToBackup[] = $this->fileVerifyName;

            $itemsToBackup = implode(' ', $itemsToBackup);

            $command = 'cd ' . str_replace(
                '\\',
                '/',
                base_path()
            ) . " && $this->tar -cpzf $this->fBackupName $itemsToBackup";
            //exit($command);

            shell_exec($command . ' 2>&1');

            if (file_exists(base_path($this->fBackupName))) {
                $storageLocal = Storage::createLocalDriver(['root' => base_path()]);
                $file = $storageLocal->get($this->fBackupName);

                Storage::disk($this->disk)->put($this->backupPath . $this->fBackupName, $file);

                // delete local file
                $storageLocal->delete($this->fBackupName);
            }
        }
    }

    /**
     * Backup Database
     */
    protected function backupDatabase()
    {
        if (config('backupmanager.backups.database.enable')) {
            // delete previous backup for same date
            // if (Storage::disk($this->disk)->exists($this->backupPath . $this->dBackupName)) {
            //     Storage::disk($this->disk)->delete($this->backupPath . $this->dBackupName);
            // }

            # this will be used to verify later if restore was successful
            DB::statement(" INSERT INTO verifybackup (id, verify_status) VALUES (1, 'backup') ON DUPLICATE KEY UPDATE verify_status = 'backup' ");

            $connection = [
                'host' => config('database.connections.mysql.host'),
                'database' => config('database.connections.mysql.database'),
                'username' => config('database.connections.mysql.username'),
                'password' => config('database.connections.mysql.password'),
            ];


            $tableOptions = '';
            $connectionOptions = "--user={$connection['username']} --password=\"{$connection['password']}\" --host={$connection['host']} {$connection['database']} ";

            // https://mariadb.com/kb/en/library/mysqldump/
            $options = [
                '--single-transaction',
                // '--max-allowed-packet=4096',
                '--quick',
                // '--force', // ignore errors
                //'--set-gtid-purged=OFF',
                // '--skip-lock-tables',
            ];

            $options = implode(' ', $options);

            $itemsToBackup = config('backupmanager.backups.database.tables');

            // \DB::unprepared('FLUSH TABLES WITH READ LOCK;');

            // run the artisan command to backup the db using the package I linked to
            // \Artisan::call('backup:run', ['--only-db' => true]);  // something like this

            // unlock all tables
            // \DB::unprepared('UNLOCK TABLES');
            if ($itemsToBackup) {
                // also add our backup verifier
                $itemsToBackup[] = 'verifybackup';

                $tableOptions = implode(' ', $itemsToBackup);
                // dd($tableOptions);

            }

            // dump($this->dBackupName);

            // dd("$this->input_db_name.gz");

            // dd($tableOptions);

            // DatabaseInformation::create(['name' => $this->input_db_name, 'status' => 0, 'database_storage_name' => $this->dBackupName]);
            $command = 'cd ' . str_replace(
                '\\',
                '/',
                base_path()
            ) . " && $this->mysqldump $options $connectionOptions $tableOptions | gzip > $this->dBackupName";

            shell_exec($command . " 2>&1");
            if (file_exists(base_path($this->dBackupName))) {
                $storageLocal = Storage::createLocalDriver(['root' => base_path()]);
                $file = $storageLocal->get($this->dBackupName);
                // dd($file);

                // dd($this->backupPath);
                Storage::disk($this->disk)->put($this->backupPath . $this->dBackupName, $file);



                // delete local file
                $storageLocal->delete($this->dBackupName);
            }
        }
    }

    protected function restoreFiles($file)
    {
        if (Storage::disk($this->disk)->exists($this->backupPath . $file)) {

            $storageLocal = Storage::createLocalDriver(['root' => base_path()]);
            $contents = Storage::disk($this->disk)->get($this->backupPath . $file);

            $storageLocal->put($file, $contents);

            if (file_exists(base_path($file))) {

                file_put_contents(base_path($this->fileVerifyName), 'restore');

                $command = 'cd ' . str_replace('\\', '/', base_path()) . " && $this->tar -xzf $file";
                //exit($command);

                shell_exec($command . ' 2>&1');

                // delete local file
                $storageLocal->delete($file);
            }
        }
    }

    protected function restoreDatabase($file)
    {
        if (Storage::disk($this->disk)->exists($this->backupPath . $file)) {

            $storageLocal = Storage::createLocalDriver(['root' => base_path()]);
            $contents = Storage::disk($this->disk)->get($this->backupPath . $file);

            $storageLocal->put($file, $contents);

            if (file_exists(base_path($file))) {




                DB::statement(" INSERT INTO verifybackup (id, verify_status) VALUES (1, 'restore') ON DUPLICATE KEY UPDATE verify_status = 'restore' ");

                $connection = [
                    'host' => config('database.connections.mysql.host'),
                    'database' => config('database.connections.mysql.database'),
                    'username' => config('database.connections.mysql.username'),
                    'password' => config('database.connections.mysql.password'),
                ];

                $connectionOptions = "-u {$connection['username']} ";

                if (trim($connection['password'])) {
                    $connectionOptions .= " -p\"{$connection['password']}\" ";
                }

                $connectionOptions .= " -h {$connection['host']} {$connection['database']} ";

                //$command = "$cd gunzip < $this->fBackupName | mysql $connectionOptions";
                $command = 'cd ' . str_replace(
                    '\\',
                    '/',
                    base_path()
                ) . " && $this->zcat $file | mysql $connectionOptions";
                //exit($command);

                shell_exec($command . ' 2>&1');

                // delete local file
                $storageLocal->delete($file);
            }
        }
    }

    /**
     * Verifies backup status for files and database
     *
     * @return array
     */
    protected function getBackupStatus()
    {
        @unlink(base_path($this->fileVerifyName));

        $fStatus = false;
        $dStatus = false;

        $okSizeBytes = 1024;

        // dd("INPUT" . $this->input_db_name);

        if (config('backupmanager.backups.files.enable') && (Storage::disk($this->disk)->exists($this->backupPath . $this->fBackupName) && Storage::disk($this->disk)->size($this->backupPath . $this->fBackupName) > $okSizeBytes)) {
            $fStatus = true;
        }

        if (config('backupmanager.backups.database.enable') && (Storage::disk($this->disk)->exists($this->backupPath . $this->dBackupName) && Storage::disk($this->disk)->size($this->backupPath . $this->dBackupName) > $okSizeBytes)) {

            $dStatus = true;
        }

        return ['f' => $fStatus, 'd' => $dStatus];
    }

    protected function getRestoreStatus($isFiles)
    {
        // for files
        if ($isFiles) {
            $contents = file_get_contents(base_path($this->fileVerifyName));

            @unlink(base_path($this->fileVerifyName));

            return ['f' => $contents === 'restore'];
        }

        // for db
        $dbStatus = false;
        $data = DB::select(' SELECT verify_status FROM verifybackup WHERE id = 1 ');

        if ($data && isset($data[0])) {
            $dbStatus = $data[0]->verify_status;
        }
        return ['d' => $dbStatus === 'restore'];
    }

    /**
     * Deleted older backups
     *
     * @return void
     */
    protected function deleteOldBackups()
    {
        $daysOldToDelete = (int)config('backupmanager.backups.delete_old_backup_days');
        $now = time();

        $files = Storage::disk($this->disk)->listContents($this->backupPath);

        foreach ($files as $file) {
            if ($file['type'] !== 'file') {
                continue;
            }

            if ($now - $this->getFileTimeStamp($file) >= 60 * 60 * 24 * $daysOldToDelete) {
                if (Storage::disk($this->disk)->exists($this->backupPath . $file['basename'])) {
                    Storage::disk($this->disk)->delete($this->backupPath . $file['basename']);

                    Log::info('Deleted old backup file: ' . $file['basename']);
                }
            }
        }
    }

    protected function getFileTimeStamp(array $file)
    {
        if (isset($file['timestamp'])) {
            return $file['timestamp'];
        }

        // otherwise get date from file name
        $array = explode('_', $file['filename']);

        return strtotime(end($array));
    }

    protected function formatSizeUnits($size)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;

        return number_format($size / (1024 ** $power), 2, '.', ',') . ' ' . $units[$power];
    }
}
