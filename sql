INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'Admin', 'web', '2021-11-12 14:12:35', NULL);
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'Supplier', 'web', '2021-11-12 14:12:35', NULL);
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'Customer', 'web', '2021-11-12 14:12:35', NULL);
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'Manufacturer', 'web', '2021-11-12 14:12:35', NULL);


INSERT INTO `categories` (`id`, `name`, `image`, `isActive`, `created_at`, `updated_at`) VALUES (NULL, 'Category 1', 'default.png', '1', '2021-11-12 14:36:29', NULL);
INSERT INTO `categories` (`id`, `name`, `image`, `isActive`, `created_at`, `updated_at`) VALUES (NULL, 'Category 2', 'default.png', '1', '2021-11-12 14:36:29', NULL);
INSERT INTO `categories` (`id`, `name`, `image`, `isActive`, `created_at`, `updated_at`) VALUES (NULL, 'Category 3', 'default.png', '1', '2021-11-12 14:36:29', NULL);
INSERT INTO `categories` (`id`, `name`, `image`, `isActive`, `created_at`, `updated_at`) VALUES (NULL, 'Category 4', 'default.png', '1', '2021-11-12 14:36:29', NULL);
INSERT INTO `categories` (`id`, `name`, `image`, `isActive`, `created_at`, `updated_at`) VALUES (NULL, 'Category 5', 'default.png', '1', '2021-11-12 14:36:29', NULL);


INSERT INTO `units` (`id`, `name`, `symbol`, `abbreviation`, `isActive`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Kilogram', 'kg', 'kg', '1', '2021-11-12 14:37:46', NULL, NULL);
INSERT INTO `units` (`id`, `name`, `symbol`, `abbreviation`, `isActive`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Liter', 'l', 'l', '1', '2021-11-12 14:37:46', NULL, NULL);
INSERT INTO `units` (`id`, `name`, `symbol`, `abbreviation`, `isActive`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'meter', 'm', 'm', '1', '2021-11-12 14:37:46', NULL, NULL);
INSERT INTO `units` (`id`, `name`, `symbol`, `abbreviation`, `isActive`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'feet', 'f', 'f', '1', '2021-11-12 14:37:46', NULL, NULL);


INSERT INTO `users` (`id`, `first_name`, `last_name`, `image`, `email`, `email_verified_at`, `password`, `franchise_name`, `mobilenumber`, `address`, `isBlocked`, `isBookmarked`, `isActive`, `fax_number`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'One ', 'Supplier', NULL, 'supplier1@gmail.com', NULL, '$2a$12$Bl1vLNycgEinHpDtBwotyOQMS1OYMopO4mLGKq3eX4eOUHqWXADHC', 'Supplier One', '123456789', 'sdfjkaksdjfjkasd', '0', '0', '1', '7678687678', NULL, NULL, NULL);
INSERT INTO `users` (`id`, `first_name`, `last_name`, `image`, `email`, `email_verified_at`, `password`, `franchise_name`, `mobilenumber`, `address`, `isBlocked`, `isBookmarked`, `isActive`, `fax_number`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Two ', 'Supplier2', NULL, 'supplier2@gmail.com', NULL, '$2a$12$Bl1vLNycgEinHpDtBwotyOQMS1OYMopO4mLGKq3eX4eOUHqWXADHC', 'Supplier Two', '123456789', 'sdfjkaksdjfjkasd', '0', '0', '1', '7678687678', NULL, NULL, NULL);
INSERT INTO `users` (`id`, `first_name`, `last_name`, `image`, `email`, `email_verified_at`, `password`, `franchise_name`, `mobilenumber`, `address`, `isBlocked`, `isBookmarked`, `isActive`, `fax_number`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Three ', 'Supplier3', NULL, 'supplier3@gmail.com', NULL, '$2a$12$Bl1vLNycgEinHpDtBwotyOQMS1OYMopO4mLGKq3eX4eOUHqWXADHC', 'Supplier Three', '123456789', 'sdfjkaksdjfjkasd', '0', '0', '1', '7678687678', NULL, NULL, NULL);
INSERT INTO `users` (`id`, `first_name`, `last_name`, `image`, `email`, `email_verified_at`, `password`, `franchise_name`, `mobilenumber`, `address`, `isBlocked`, `isBookmarked`, `isActive`, `fax_number`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Four ', 'Supplier4', NULL, 'supplier4@gmail.com', NULL, '$2a$12$Bl1vLNycgEinHpDtBwotyOQMS1OYMopO4mLGKq3eX4eOUHqWXADHC', 'Supplier Four', '123456789', 'sdfjkaksdjfjkasd', '0', '0', '1', '7678687678', NULL, NULL, NULL);


INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('2', 'App\\Models\\User', '2');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('2', 'App\\Models\\User', '3');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('2', 'App\\Models\\User', '4');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('2', 'App\\Models\\User', '5');


INSERT INTO `products` (`id`, `name`, `price`, `index`, `image`, `description`, `isActive`, `min_req_qty`, `category_id`, `manufacturing_partner_id`, `supplier_id`, `unit_id`, `quantity`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Product 2', '692', '30', 'default.png', '<p>Product 2</p>', '1', '0', '2', NULL, '4', '1', '453', '2021-11-12 09:51:10', '2021-11-12 09:51:10', NULL);
INSERT INTO `products` (`id`, `name`, `price`, `index`, `image`, `description`, `isActive`, `min_req_qty`, `category_id`, `manufacturing_partner_id`, `supplier_id`, `unit_id`, `quantity`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Product 3', '692', '40', 'default.png', '<p>Product 3</p>', '1', '0', '2', NULL, '3', '2', '453', '2021-11-12 09:51:10', '2021-11-12 09:51:10', NULL);
INSERT INTO `products` (`id`, `name`, `price`, `index`, `image`, `description`, `isActive`, `min_req_qty`, `category_id`, `manufacturing_partner_id`, `supplier_id`, `unit_id`, `quantity`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Product 4', '692', '30', 'default.png', '<p>Product 4</p>', '1', '0', '2', NULL, '2', '4', '453', '2021-11-12 09:51:10', '2021-11-12 09:51:10', NULL);
