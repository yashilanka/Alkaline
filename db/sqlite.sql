CREATE TABLE `citations` (`citation_id` INTEGER, `post_id` INTEGER, `page_id` INTEGER, `citation_type` TEXT, `citation_uri` TEXT, `citation_uri_requested` TEXT, `citation_description` TEXT, `citation_title` TEXT, `citation_site_name` TEXT, `citation_created` TEXT, `citation_modified` TEXT, PRIMARY KEY (`citation_id`));
CREATE TABLE `cities` (`city_id` INTEGER, `city_name` TEXT, `city_state` TEXT, `country_code` TEXT, `city_name_raw` TEXT, `city_name_alt` TEXT, `city_pop` INTEGER, `city_lat` REAL, `city_long` REAL, `city_class` TEXT, `city_code` TEXT, PRIMARY KEY (`city_id`));
CREATE TABLE `comments` (`comment_id` INTEGER, `image_id` INTEGER, `post_id` INTEGER, `user_id` INTEGER, `comment_created` TEXT, `comment_status` INTEGER, `comment_text` TEXT, `comment_text_raw` TEXT, `comment_markup` TEXT, `comment_author_name` TEXT, `comment_author_uri` TEXT, `comment_author_email` TEXT, `comment_author_ip` TEXT, `comment_author_avatar` TEXT, `comment_response` INTEGER, `comment_modified` TEXT, `comment_deleted` TEXT, PRIMARY KEY (`comment_id`));
CREATE TABLE `countries` (`country_id` INTEGER, `country_code` TEXT, `country_name` TEXT, PRIMARY KEY (`country_id`));
CREATE TABLE `exifs` (`exif_id` INTEGER, `image_id` INTEGER, `exif_key` TEXT, `exif_name` TEXT, `exif_value` TEXT, PRIMARY KEY (`exif_id`));
CREATE TABLE `extensions` (`extension_id` INTEGER, `extension_uid` TEXT, `extension_class` TEXT, `extension_title` TEXT, `extension_status` INTEGER, `extension_build` INTEGER, `extension_build_latest` INTEGER, `extension_version` TEXT, `extension_version_latest` TEXT, `extension_hooks` TEXT, `extension_preferences` TEXT, `extension_folder` TEXT,  `extension_file` TEXT, `extension_description` TEXT, `extension_creator_name` TEXT, `extension_creator_uri` TEXT, PRIMARY KEY (`extension_id`));
CREATE TABLE `guests` (`guest_id` INTEGER, `guest_title` TEXT, `guest_key` TEXT, `guest_sets` TEXT, `guest_last_login` TEXT, `guest_created` TEXT, `guest_views` INTEGER, `guest_inclusive` INTEGER, PRIMARY KEY (`guest_id`));
CREATE TABLE `images` (`image_id` INTEGER, `user_id` INTEGER, `right_id` INTEGER, `image_ext` TEXT, `image_mime` TEXT, `image_title` TEXT, `image_description` TEXT, `image_description_raw` TEXT, `image_markup` TEXT, `image_privacy` INTEGER, `image_name` TEXT, `image_colors` TEXT, `image_color_r` INTEGER, `image_color_g` INTEGER, `image_color_b` INTEGER, `image_color_h` INTEGER, `image_color_s` INTEGER, `image_color_l` INTEGER, `image_taken` TEXT, `image_uploaded` TEXT, `image_published` TEXT, `image_modified` TEXT, `image_geo` TEXT, `image_geo_lat` REAL, `image_geo_long` REAL, `image_views` INTEGER, `image_comment_disabled` INTEGER, `image_comment_count` INTEGER, `image_height` INTEGER, `image_width` INTEGER, `image_tags` TEXT, `image_tag_count` INTEGER, `image_deleted` TEXT, `image_related` TEXT, `image_related_hash` TEXT, PRIMARY KEY (`image_id`));
CREATE TABLE `items` (`item_id` INTEGER, `item_table` TEXT, `item_table_id` INTEGER, PRIMARY KEY (`item_id`));
CREATE TABLE `links` (`link_id` INTEGER, `image_id` INTEGER, `tag_id` INTEGER, PRIMARY KEY (`link_id`));
CREATE TABLE `pages` (`page_id` INTEGER, `page_title` TEXT, `page_title_url` TEXT, `page_text` TEXT, `page_text_raw` TEXT, `page_markup` TEXT, `page_images` TEXT, `page_views` INTEGER, `page_words` INTEGER, `page_created` TEXT, `page_modified` TEXT, `page_category` TEXT, `page_deleted` TEXT, `page_excerpt` TEXT, `page_excerpt_raw` TEXT, PRIMARY KEY (`page_id`));
CREATE TABLE `posts` (`post_id` INTEGER, `user_id` INTEGER, `post_title` TEXT, `post_title_url` TEXT, `post_text` TEXT, `post_text_raw` TEXT, `post_markup` TEXT, `post_images` TEXT, `post_views` INTEGER, `post_words` INTEGER, `post_created` TEXT, `post_published` TEXT, `post_modified` TEXT, `post_comment_count` INTEGER, `post_comment_disabled` INTEGER, `post_category` TEXT, `post_deleted` TEXT, `post_related` TEXT, `post_related_hash` TEXT, `post_tags` TEXT, `post_citations` TEXT, `post_excerpt` TEXT, `post_excerpt_raw` TEXT, `post_source` TEXT, `post_trackback_count` INTEGER, `post_trackback_sent` INTEGER, `post_geo` TEXT, `post_geo_lat` REAL, `post_geo_long` REAL, `right_id` INTEGER, PRIMARY KEY (`post_id`));
CREATE TABLE `rights` (`right_id` INTEGER, `right_title` TEXT, `right_uri` TEXT, `right_image` TEXT, `right_description` TEXT, `right_created` TEXT, `right_modified` TEXT, `right_image_count` INTEGER, `right_deleted` TEXT, `right_markup` TEXT, `right_description_raw` TEXT, PRIMARY KEY (`right_id`));
CREATE TABLE `sets` (`set_id` INTEGER, `set_title` TEXT, `set_title_url` TEXT, `set_type` TEXT, `set_description` TEXT, `set_images` TEXT, `set_views` INTEGER, `set_image_count` INTEGER, `set_call` TEXT, `set_request` TEXT, `set_modified` TEXT, `set_created` TEXT, `set_deleted` TEXT, `set_markup` TEXT, `set_description_raw` TEXT, PRIMARY KEY (`set_id`));
CREATE TABLE `sizes` (`size_id` INTEGER, `size_title` TEXT, `size_label` TEXT, `size_height` INTEGER, `size_width` INTEGER, `size_type` TEXT, `size_append` TEXT, `size_prepend` TEXT, `size_watermark` INTEGER, `size_modified` TEXT, PRIMARY KEY (`size_id`));
CREATE TABLE `stats` (`stat_id` INTEGER, `stat_session` TEXT, `stat_date` TEXT, `stat_duration` INTEGER, `stat_referrer` TEXT, `stat_page` TEXT, `stat_page_type` TEXT, `stat_local` INTEGER, `user_id` INTEGER, `guest_id` INTEGER, PRIMARY KEY (`stat_id`));
CREATE TABLE `tags` (`tag_id` INTEGER, `tag_name` TEXT, `tag_parents` TEXT, PRIMARY KEY (`tag_id`));
CREATE TABLE `themes` (`theme_id` INTEGER, `theme_uid` TEXT, `theme_title` TEXT, `theme_build` INTEGER, `theme_build_latest` INTEGER, `theme_version` TEXT, `theme_version_latest` TEXT, `theme_folder` TEXT, `theme_creator_name` TEXT, `theme_creator_uri` TEXT, PRIMARY KEY (`theme_id`));
CREATE TABLE `trackbacks` (`trackback_id` INTEGER, `post_id` INTEGER, `trackback_uri` TEXT, `trackback_title` TEXT, `trackback_excerpt` TEXT, `trackback_blog_name` TEXT, `trackback_ip` TEXT, `trackback_created` TEXT, PRIMARY KEY (`trackback_id`));
CREATE TABLE `users` (`user_id` INTEGER, `user_user` TEXT, `user_pass` TEXT, `user_pass_salt` TEXT, `user_key` TEXT, `user_name` TEXT, `user_email` TEXT, `user_last_login` TEXT, `user_created` TEXT, `user_permissions` TEXT, `user_preferences` TEXT, `user_image_count` INTEGER, `user_uri` TEXT, `user_post_count` INTEGER, `user_comment_count` INTEGER, PRIMARY KEY (`user_id`));
CREATE TABLE `versions` (`version_id` INTEGER, `post_id` INTEGER, `page_id` INTEGER, `user_id` INTEGER, `version_title` TEXT, `version_text_raw` TEXT, `version_created` TEXT, `version_similarity` INTEGER, PRIMARY KEY (`version_id`));