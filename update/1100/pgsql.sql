CREATE TABLE "citations" ("citation_id" SERIAL PRIMARY KEY, "post_id" INTEGER, "page_id" INTEGER, "citation_type" TEXT, "citation_uri" TEXT, "citation_uri_requested" TEXT, "citation_description" TEXT, "citation_title" TEXT, "citation_site_name" TEXT, "citation_created" TIMESTAMP, "citation_modified" TIMESTAMP);
ALTER TABLE "comments" ADD "comment_response" INTEGER;
ALTER TABLE "comments" ADD "comment_modified" TIMESTAMP;
ALTER TABLE "comments" ADD "comment_deleted" TIMESTAMP;
ALTER TABLE "guests" ADD "guest_inclusive" INTEGER;
ALTER TABLE "images" ADD "image_deleted" TIMESTAMP;
ALTER TABLE "images" ADD "image_tags" TEXT;
ALTER TABLE "images" ADD "image_related" TEXT;
ALTER TABLE "images" ADD "image_related_hash" TEXT;
ALTER TABLE "images" ADD "image_directory" TEXT;
ALTER TABLE "images" ADD "image_tag_count" INTEGER;
ALTER TABLE "pages" ADD "page_deleted" TIMESTAMP;
ALTER TABLE "pages" ADD "page_excerpt" TEXT;
ALTER TABLE "pages" ADD "page_excerpt_raw" TEXT;
ALTER TABLE "pages" ADD "page_category" TEXT;
ALTER TABLE "posts" ADD "post_deleted" TIMESTAMP;
ALTER TABLE "posts" ADD "post_related" TEXT;
ALTER TABLE "posts" ADD "post_related_hash" TEXT;
ALTER TABLE "posts" ADD "post_tags" TEXT;
ALTER TABLE "posts" ADD "post_citations" TEXT;
ALTER TABLE "posts" ADD "post_category" TEXT;
ALTER TABLE "posts" ADD "post_excerpt" TEXT;
ALTER TABLE "posts" ADD "post_excerpt_raw" TEXT;
ALTER TABLE "posts" ADD "post_source" TEXT;
ALTER TABLE "posts" ADD "post_trackback_count" INTEGER;
ALTER TABLE "posts" ADD "post_trackback_sent" INTEGER;
ALTER TABLE "posts" ADD "post_geo" TEXT;
ALTER TABLE "posts" ADD "post_geo_lat" REAL;
ALTER TABLE "posts" ADD "post_geo_long" REAL;
ALTER TABLE "posts" ADD "right_id" INTEGER;
ALTER TABLE "rights" ADD "right_deleted" TIMESTAMP;
ALTER TABLE "rights" ADD "right_markup" TEXT;
ALTER TABLE "rights" ADD "right_description_raw" TEXT;
ALTER TABLE "sets" ADD "set_deleted" TIMESTAMP;
ALTER TABLE "sets" ADD "set_markup" TEXT;
ALTER TABLE "sets" ADD "set_description_raw" TEXT;
ALTER TABLE "sizes" ADD "size_modified" TIMESTAMP;
ALTER TABLE "tags" ADD "tag_parents" TEXT;
ALTER TABLE "users" ADD "user_uri" TEXT;
ALTER TABLE "users" ADD "user_post_count" INTEGER;
ALTER TABLE "users" ADD "user_comment_count" INTEGER;
CREATE TABLE "items" ("item_id" SERIAL PRIMARY KEY, "item_table" TEXT, "item_table_id" INTEGER, PRIMARY KEY ("item_id"));
CREATE TABLE "trackbacks" ("trackback_id" SERIAL PRIMARY KEY, "post_id" INTEGER, "trackback_uri" TEXT, "trackback_title" TEXT, "trackback_excerpt" TEXT, "trackback_blog_name" TEXT, "trackback_ip" TEXT, "trackback_created" TIMESTAMP);
CREATE TABLE "versions" ("version_id" SERIAL PRIMARY KEY, "post_id" INTEGER, "page_id" INTEGER, "user_id" INTEGER, "version_title" TEXT, "version_text_raw" TEXT, "version_created" TIMESTAMP, "version_similarity" INTEGER);