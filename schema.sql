-------------------------------------------------------------------
-- Drop Schema
-------------------------------------------------------------------


DROP SCHEMA lbaw22124;


-------------------------------------------------------------------
-- Create Schema
-------------------------------------------------------------------


CREATE SCHEMA lbaw22124;
SET search_path TO lbaw22124;

-------------------------------------------------------------------
-- Types
-------------------------------------------------------------------


CREATE TYPE report_reason AS ENUM ('Breaks Community Rules', 'Breaks Rabbit TOS', 'Explicit Content', 'Hate Speech', 'Sharing Personal Information', 'Spam', 'Misinformation');
CREATE TYPE community_tag AS ENUM ('Sports', 'Gaming', 'News', 'TV', 'Memes', 'Travel', 'Tech', 'Music', 'Art', 'Literature', 'Fashion', 'Finance', 'Food', 'Health and Fitness', 'Science');


-------------------------------------------------------------------
-- Drop Tables
-------------------------------------------------------------------


DROP TABLE IF EXISTS administrator;
DROP TABLE IF EXISTS platform_block;
DROP TABLE IF EXISTS follow_notification;
DROP TABLE IF EXISTS reply_notification;
DROP TABLE IF EXISTS like_notification;
DROP TABLE IF EXISTS content;
DROP TABLE IF EXISTS content_rate;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS text_post;
DROP TABLE IF EXISTS img_post;
DROP TABLE IF EXISTS favorite_post;
DROP TABLE IF EXISTS report_information;
DROP TABLE IF EXISTS report_reason;
DROP TABLE IF EXISTS community_tag;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS users_profile_img;
DROP TABLE IF EXISTS community_icon_img;
DROP TABLE IF EXISTS community_banner_img;
DROP TABLE IF EXISTS user_follow_user;
DROP TABLE IF EXISTS user_follow_community;
DROP TABLE IF EXISTS moderator;
DROP TABLE IF EXISTS community_block;


-------------------------------------------------------------------
-- Create Tables
-------------------------------------------------------------------


CREATE TABLE administrator (
  id SERIAL PRIMARY KEY,
  username TEXT,
  password TEXT
);

CREATE TABLE users (
  id SERIAL PRIMARY KEY, 
  username TEXT CONSTRAINT user_username UNIQUE,
  password TEXT,
  email TEXT CONSTRAINT user_email UNIQUE,
  biography TEXT,
  register_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE user_follow_user (
  id_follower INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  id_followee INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  PRIMARY KEY (id_follower, id_followee)
);

CREATE TABLE users_profile_img (
  id SERIAL PRIMARY KEY,
  id_user INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE
);

CREATE TABLE community (
  id SERIAL PRIMARY KEY,
  id_owner INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  name TEXT NOT NULL CONSTRAINT community_name UNIQUE,
  description TEXT,
  founded TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  tag COMMUNITY_TAG NOT NULL
);

CREATE TABLE user_follow_community (
  id_follower INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  id_followee INTEGER NOT NULL REFERENCES community (id) ON UPDATE CASCADE,
  PRIMARY KEY (id_follower, id_followee)
);

CREATE TABLE moderator (
  id_mod INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  id_community INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  PRIMARY KEY (id_mod, id_community)
);

CREATE TABLE community_icon_img (
  id SERIAL PRIMARY KEY,
  id_community INTEGER NOT NULL REFERENCES community (id) ON UPDATE CASCADE
);

CREATE TABLE community_banner_img (
  id SERIAL PRIMARY KEY,
  id_community INTEGER NOT NULL REFERENCES community (id) ON UPDATE CASCADE
);

CREATE TABLE content (
  id SERIAL PRIMARY KEY,
  id_author INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  created TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  is_post BOOLEAN NOT NULL
);

CREATE TABLE content_rate (
  id_content INTEGER NOT NULL REFERENCES content (id) ON UPDATE CASCADE,
  id_user INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  liked BOOLEAN NOT NULL,
  PRIMARY KEY (id_content, id_user)
);

CREATE TABLE comment (
  id INTEGER PRIMARY KEY REFERENCES content (id),
  id_parent INTEGER NOT NULL REFERENCES comment (id) ON UPDATE CASCADE,
  text TEXT NOT NULL
);

CREATE TABLE tag (
  id SERIAL PRIMARY KEY,
  id_community INTEGER NOT NULL REFERENCES community (id) ON UPDATE CASCADE,
  name TEXT NOT NULL
);

CREATE TABLE post (
  id INTEGER PRIMARY KEY REFERENCES content (id) ON UPDATE CASCADE, 
  id_community INTEGER NOT NULL REFERENCES community (id) ON UPDATE CASCADE,
  id_tag INTEGER NOT NULL REFERENCES tag (id) ON UPDATE CASCADE,
  title TEXT NOT NULL,
  is_image BOOLEAN NOT NULL
);

CREATE TABLE text_post (
  id INTEGER PRIMARY KEY REFERENCES post (id) ON UPDATE CASCADE,
  text TEXT NOT NULL
);

CREATE TABLE image_post (
  id SERIAL PRIMARY KEY,
  id_image INTEGER NOT NULL REFERENCES post (id) ON UPDATE CASCADE
);

CREATE TABLE favorite_post (
  id_post INTEGER NOT NULL REFERENCES post (id) ON UPDATE CASCADE,
  id_user INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  PRIMARY KEY (id_post, id_user)
);

CREATE TABLE platform_block (
  id SERIAL PRIMARY KEY,
  id_admin INTEGER NOT NULL REFERENCES administrator (id) ON UPDATE CASCADE,
  reason TEXT NOT NULL,
  start_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  end_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE community_block (
  id_blockee INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  id_community INTEGER NOT NULL REFERENCES community (id) ON UPDATE CASCADE,
  reason TEXT NOT NULL,
  start_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  end_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  PRIMARY KEY (id_blockee, id_community) 
);

CREATE TABLE report_information (
  id_content INTEGER NOT NULL REFERENCES content (id) ON UPDATE CASCADE,
  id_user INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  reason REPORT_REASON NOT NULL,
  report_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  reviewed BOOLEAN NOT NULL,
  PRIMARY KEY (id_content, id_user)
);

CREATE TABLE follow_notification (
  id SERIAL PRIMARY KEY,
  id_received INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  id_triggered INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  created TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL, 
  read BOOLEAN NOT NULL 
);

CREATE TABLE reply_notification (
  id SERIAL PRIMARY KEY,
  id_received INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE, 
  id_triggered INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  id_comment INTEGER NOT NULL references comment (id) ON UPDATE CASCADE,
  created TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  read BOOLEAN NOT NULL
);

CREATE TABLE like_notification (
  id SERIAL PRIMARY KEY,
  id_received INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE, 
  id_triggered INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  id_content INTEGER NOT NULL references content (id) ON UPDATE CASCADE,
  created TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  read BOOLEAN NOT NULL
);
