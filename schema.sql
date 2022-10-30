-------------------------------------------------------------------
-- Drop Schema
-------------------------------------------------------------------


DROP SCHEMA lbaw22124 CASCADE;


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
-- Create Tables
-------------------------------------------------------------------


CREATE TABLE administrator (
  id SERIAL PRIMARY KEY,
  username TEXT,
  password TEXT
);

CREATE TABLE users (
  id SERIAL PRIMARY KEY, 
  username TEXT CONSTRAINT user_username UNIQUE NOT NULL,
  password TEXT NOT NULL,
  email TEXT CONSTRAINT user_email UNIQUE NOT NULL,
  register_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  biography TEXT,
  pfp INTEGER DEFAULT NULL,
  is_deleted BOOLEAN NOT NULL DEFAULT FALSE 
);

CREATE TABLE user_follow_user (
  id_follower INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  id_followee INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  PRIMARY KEY (id_follower, id_followee)
);

CREATE TABLE community (
  id SERIAL PRIMARY KEY,
  id_owner INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  name TEXT NOT NULL CONSTRAINT community_name UNIQUE,
  description TEXT,
  founded TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  tag COMMUNITY_TAG NOT NULL,
  icon INTEGER NOT NULL,
  banner INTEGER,
  is_deleted BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE user_follow_community (
  id_follower INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  id_followee INTEGER NOT NULL REFERENCES community (id) ON UPDATE CASCADE,
  PRIMARY KEY (id_follower, id_followee)
);

CREATE TABLE moderator (
  id_mod INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  id_community INTEGER NOT NULL REFERENCES community (id) ON UPDATE CASCADE,
  PRIMARY KEY (id_mod, id_community)
);

CREATE TABLE content (
  id SERIAL PRIMARY KEY,
  id_author INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  created TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  is_post BOOLEAN NOT NULL,
  is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
  is_edited BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE content_rate (
  id_content INTEGER NOT NULL REFERENCES content (id) ON UPDATE CASCADE,
  id_user INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  liked BOOLEAN NOT NULL,
  PRIMARY KEY (id_content, id_user)
);

CREATE TABLE comment (
  id INTEGER PRIMARY KEY REFERENCES content (id),
  id_parent INTEGER NOT NULL REFERENCES content (id) ON UPDATE CASCADE,
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
  read BOOLEAN NOT NULL DEFAULT FALSE
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


-------------------------------------------------------------------
-- Indices
-------------------------------------------------------------------

-------------------------------------------------------------------
-- Performance Indices
-------------------------------------------------------------------


CREATE INDEX post_community ON post USING hash (id_community);

CREATE INDEX users_username ON users USING btree (username);

CREATE INDEX content_date ON content USING btree (created);


-------------------------------------------------------------------
-- Full-Text Search Indexes
-------------------------------------------------------------------


-- Index to improve the performance when searching for a post by it's title

ALTER TABLE post
ADD COLUMN tsvectors TSVECTOR; 

CREATE FUNCTION post_search_update() RETURNS TRIGGER AS $$
BEGIN 
  IF TG_OP = 'INSERT' THEN 
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.title), 'A')
    );
  END IF;
  IF TG_OP = 'UPDATE' THEN
    IF (NEW.title <> OLD.title) THEN 
      NEW.tsvectors = (
        setweight(to_tsvector('english', NEW.title), 'A')
      );
    END IF;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER post_search_update
  BEFORE INSERT OR UPDATE ON post
  FOR EACH ROW 
  EXECUTE PROCEDURE post_search_update();

CREATE INDEX post_search ON post USING GIN (tsvectors);


-------------------------------------


-- Index to improve the performance when searching for a text post by its content

ALTER TABLE text_post 
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION text_post_search_update() RETURNS TRIGGER AS $$
BEGIN 
  IF TG_OP = 'INSERT' THEN 
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.text), 'A') 
    );
  END IF;
  IF TG_OP = 'UPDATE' THEN
    IF (NEW.text <> OLD.text) THEN 
      NEW.tsvectors = (
        setweight(to_tsvector('english', NEW.text), 'A')
      );
    END IF;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER text_post_search_update
  BEFORE INSERT OR UPDATE ON post
  FOR EACH ROW 
  EXECUTE PROCEDURE text_post_search_update();

CREATE INDEX text_post_search ON text_post USING GIN (tsvectors);


-------------------------------------


-- Index to improve the perfomance when searching for a comment 

ALTER TABLE COMMENT
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION comment_search_update() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.text), 'A')
    );
  END IF;
  IF TG_OP = 'UPDATE' THEN
    IF (NEW.text <> OLD.text) THEN
      NEW.tsvectors = (
        setweight(to_tsvector('english', NEW.text), 'A')
      );
    END IF;
  END IF;
  RETURN NEW; 
END $$
LANGUAGE plpgsql;

CREATE TRIGGER comment_search_update 
  BEFORE INSERT OR UPDATE ON comment
  FOR EACH ROW
  EXECUTE PROCEDURE comment_search_update();

CREATE INDEX comment_search ON comment USING GIN(tsvectors);


-------------------------------------


-- Index to improve the performance when searching for users by their username or biopgrahy

ALTER TABLE users
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION user_search_update() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.username), 'A') ||
      setweight(to_tsvector('english', NEW.biography), 'B')
    );
  END IF;
  IF TG_OP = 'UPDATE' THEN
    IF (NEW.biography <> OLD.biography) THEN
      NEW.tsvectors = (
        setweight(to_tsvector('english', NEW.username), 'A') ||
        setweight(to_tsvector('english', NEW.biography), 'B')
      );
    END IF;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER user_search_update
  BEFORE INSERT OR UPDATE ON users
  FOR EACH ROW
  EXECUTE PROCEDURE user_search_update();

CREATE INDEX user_search ON users USING GIN(tsvectors);


-------------------------------------------------------------------
-- Triggers
-------------------------------------------------------------------

-- Trigger 01

CREATE FUNCTION follow_notif() RETURNS TRIGGER AS 
$BODY$
BEGIN 
  INSERT INTO follow_notification(id_received, id_triggered) VALUES(NEW.id_followee, NEW.id_follower);
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER follow_notif
  AFTER INSERT ON user_follow_user
  FOR EACH ROW 
  EXECUTE PROCEDURE follow_notif(); 


-- Trigger 02

CREATE FUNCTION like_notif() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF (NEW.liked = TRUE) THEN
    INSERT INTO like_notification(id_received, id_triggered, id_content) 
    (SELECT content.id_author,
            NEW.id_user AS id_user,
            NEW.id_content AS id_content
            FROM content
            WHERE content.id = NEW.id_content);
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER like_notif
  AFTER INSERT ON content_rate
  FOR EACH ROW
  EXECUTE PROCEDURE like_notif();


-- Trigger 03

CREATE OR REPLACE FUNCTION get_author(id_comment INTEGER)
RETURNS INTEGER AS $id_author$
DECLARE
  id_author INTEGER;
BEGIN
  SELECT content.id_author INTO id_author FROM content WHERE content.id = id_comment;
  RETURN id_author;
END;
$id_author$ LANGUAGE plpgsql; 

CREATE FUNCTION reply_notif() RETURNS TRIGGER AS
$BODY$
BEGIN
  INSERT INTO reply_notification(id_received, id_triggered, id_comment)
  (SELECT (SELECT get_author(NEW.id_parent)), 
          (SELECT get_author(NEW.id)), 
           NEW.id AS id_comment);
END
$BODY$  
LANGUAGE plpgsql;

CREATE TRIGGER reply_notif
  AFTER INSERT ON comment
  FOR EACH ROW
  EXECUTE PROCEDURE reply_notif();


-- Trigger 04

CREATE FUNCTION delete_user() RETURNS TRIGGER AS
$BODY$
BEGIN
  UPDATE users SET is_deleted = TRUE WHERE id = OLD.id;
  RETURN NEW;
END            
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER delete_user
  BEFORE DELETE ON users 
  FOR EACH ROW
  EXECUTE PROCEDURE delete_user();


-------------------------------------------------------------------
-- Transactions
-------------------------------------------------------------------


