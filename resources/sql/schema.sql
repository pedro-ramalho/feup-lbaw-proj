-------------------------------------------------------------------
-- Drop Schema
-------------------------------------------------------------------


DROP SCHEMA IF EXISTS lbaw22124 CASCADE;


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

CREATE TABLE users (
  id SERIAL PRIMARY KEY, 
  username TEXT CONSTRAINT user_username UNIQUE NOT NULL,
  password TEXT NOT NULL,
  email TEXT CONSTRAINT user_email UNIQUE NOT NULL,
  register_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  biography TEXT,
  pfp INTEGER DEFAULT NULL,
  is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
  is_admin BOOLEAN NOT NULL DEFAULT FALSE 
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
  id_admin INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
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
  read BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE like_notification (
  id SERIAL PRIMARY KEY,
  id_received INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE, 
  id_triggered INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  id_content INTEGER NOT NULL references content (id) ON UPDATE CASCADE,
  created TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  read BOOLEAN NOT NULL DEFAULT FALSE
);


-------------------------------------------------------------------
-- Indices
-------------------------------------------------------------------

-------------------------------------------------------------------
-- Performance Indices
-------------------------------------------------------------------


CREATE INDEX post_community ON post USING HASH (id_community);

CREATE INDEX content_date ON content USING BTREE (created);

CREATE INDEX user_content ON content USING HASH (id_author);


-------------------------------------------------------------------
-- Full-Text Search Indexes
-------------------------------------------------------------------


-- Index to improve the performance when searching for a post by it's title

ALTER TABLE post
ADD COLUMN tsvectors TSVECTOR; 

CREATE FUNCTION post_search_update() RETURNS TRIGGER AS $$
declare
record1 record;
BEGIN 
  IF TG_OP = 'INSERT' THEN 
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.title), 'A')
    );
  END IF;
  IF TG_OP = 'UPDATE' THEN
    IF (NEW.title <> OLD.title) THEN
      SELECT * into record1 FROM text_post WHERE text_post.id = NEW.id;
      NEW.tsvectors = (
        setweight(to_tsvector('english', NEW.title), 'A') || 
        setweight(to_tsvector('english', record1.text),'B')
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

CREATE FUNCTION text_post_search_update() RETURNS TRIGGER AS $$
BEGIN 
  IF TG_OP = 'INSERT' THEN 
    UPDATE post 
    SET tsvectors = (
      setweight(to_tsvector('english', title), 'A') ||
      setweight(to_tsvector('english', NEW.text), 'B')
    )
    WHERE post.id = NEW.id;
  END IF;
  IF TG_OP = 'UPDATE' THEN
    IF (NEW.text <> OLD.text) THEN 
    UPDATE post 
    SET tsvectors = (
      setweight(to_tsvector('english', title), 'A') ||
      setweight(to_tsvector('english', NEW.text), 'B')
    )
    WHERE post.id = NEW.id;

    END IF;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER text_post_search_update
  BEFORE INSERT OR UPDATE ON text_post
  FOR EACH ROW 
  EXECUTE PROCEDURE text_post_search_update();


-------------------------------------


-- Index to improve the perfomance when searching for a comment 

CREATE FUNCTION comment_search_update() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN
    UPDATE post 
    SET tsvectors = (
      post.tsvectors || setweight(to_tsvector('english', NEW.text), 'C')
    )
    WHERE post.id = NEW.id_parent;
  END IF;
  IF TG_OP = 'UPDATE' THEN
    IF (NEW.text <> OLD.text) THEN
      UPDATE post 
    SET tsvectors = (
      post.tsvectors || setweight(to_tsvector('english', NEW.text), 'C')
    )
      WHERE post.id = NEW.id_parent;
    END IF;
  END IF;
  RETURN NEW; 
END $$
LANGUAGE plpgsql;

CREATE TRIGGER comment_search_update 
  BEFORE INSERT OR UPDATE ON comment
  FOR EACH ROW
  EXECUTE PROCEDURE comment_search_update();


-------------------------------------


-- Index to improve the performance when searching for users by their username or biopgrahy

ALTER TABLE users
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION user_search_update() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.biography), 'A')
    );
  END IF;
  IF TG_OP = 'UPDATE' THEN
    IF (NEW.biography <> OLD.biography) THEN
      NEW.tsvectors = (
        setweight(to_tsvector('english', NEW.biography), 'A')
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
  RETURN NEW;
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

insert into users (username, password, email, biography, pfp, is_deleted) values ('jwiffler0', 'jQT8WYdmh', 'meskriett0@1688.com', null, null, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('estannislawski1', '$2y$10$4x8iE2ItcFYrs1e6SzOaler/MBd50UDPbUVAFfGhFUe7TIFzpzJfK', 'cwork1@adobe.com', 'Business-focused exuding encoding', 7519, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('gbaxill2', 'Em7cAwUXr', 'ratty2@linkedin.com', 'Enhanced scalable open system', 9003, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('dgostyke3', 'm5oTwBQ7sLi', 'prosenfeld3@clickbank.net', 'Business-focused systemic internet solution', 378, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('ecassam4', 'HKrOPh', 'fbucksey4@linkedin.com', null, null, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('smacairt5', 'jsTQFPKbfoib', 'gfowell5@npr.org', 'Total optimizing knowledge user', 3579, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('hchoupin6', 'yiAbrhXqBTv7', 'mgledstane6@accuweather.com', 'Focused 24 hour migration', 5374, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('palyutin7', 'nkQv8DHI', 'rgehrtz7@nasa.gov', null, null, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('sbeddis8', '5NnUUNSUt42', 'ebranchflower8@discuz.net', 'Re-engineered client-driven infrastructure', 9281, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('bgarioch9', 'R3AmtrA6', 'npiris9@purevolume.com', 'Object-based holistic knowledge user', 3428, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('msavinsa', 'FyI2BrkGo4', 'bgumleya@fotki.com', 'Synchronised analyzing firmware', 7663, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('hvinterb', '7Tk37q4', 'lsunshineb@oracle.com', null, null, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('njirekc', 'IdrmfcX68P', 'echeleyc@themeforest.net', 'Phased logistical forecast', 4356, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('agilliand', 'UJhbkxUBlT1c', 'lmcarleyd@sciencedaily.com', 'Profound needs-based artificial intelligence', 47, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('fgilfillane', 'iFr4a5', 'ebudgete@prlog.org', null, null, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('abellhamf', 'g7m9oWO', 'kbroyf@vk.com', 'Pre-emptive regional architecture', 1436, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('tdarrigog', '8CIZnj', 'manglimg@mayoclinic.com', 'Focused object-oriented definition', 9385, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('aburryh', '1RhqOdC57r', 'bhuddh@springer.com', 'Inverse high-level architecture', 1716, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('mcollissi', 'XpboRKt6FsfM', 'kkleinhandleri@hc360.com', 'Ergonomic didactic orchestration', 6874, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('rcoultishj', 'mjFMF8', 'whardeyj@census.gov', 'User-centric content-based knowledge user', 8920, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('tdunseithk', 'DjKHC8rCi', 'rstientonk@scientificamerican.com', 'Universal scalable encoding', 1809, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('chrynczykl', 'iExLw2cjgVw', 'rwagerfieldl@theguardian.com', 'Open-architected asymmetric extranet', 3861, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('tbruggerm', 'Wra8Jl', 'odegiorgism@photobucket.com', 'Streamlined web-enabled access', 5194, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('kbartolomeazzin', 'Wd4KMrqA', 'jbeevorsn@washington.edu', 'Streamlined encompassing capacity', 4698, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('nbarkwortho', '92wdrxAffCL', 'kboxallo@studiopress.com', 'User-centric real-time emulation', 401, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('agreghp', 'zE9ZLiD7nR', 'asolowayp@illinois.edu', 'Extended bandwidth-monitored moratorium', 5634, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('zlucyq', 'BR3hKK', 'dlydfordq@ask.com', 'Phased homogeneous array', 3121, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('eculpinr', '5UmNjjDjw', 'fwittierr@addthis.com', 'Sharable didactic hardware', 8104, false);
insert into users (username, password, email, biography, pfp, is_deleted) values ('jleavys', '4eibtdr3o', 'smacmasters@altervista.org', 'De-engineered logistical matrices', 8531, true);
insert into users (username, password, email, biography, pfp, is_deleted) values ('wmoggant', 'BahnQZrL', 'pwallerbridget@prweb.com', 'Business-focused directional algorithm', 8761, true);
insert into users (username, password, email, biography, pfp, is_deleted, is_admin) values('admin', '$2y$10$4x8iE2ItcFYrs1e6SzOaler/MBd50UDPbUVAFfGhFUe7TIFzpzJfK', 'admin@gmail.com', 'I am an administrator', 8762, false, true);


insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (6, 'Rank', 'Balanced asymmetric portal', 'News', 4640, 6121, false);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (24, 'Ronstring', 'Distributed leading edge parallelism', 'Health and Fitness', 76692, 6386, true);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (15, 'Aerifieda', 'Optional attitude-oriented internet solution', 'Science', 97290, 7970, true);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (24, 'Fixflex', 'Switchable multi-state array', 'Art', 29000, 9831, false);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (2, 'Transcof', 'Multi-layered local matrix', 'News', 45496, 1164, true);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (22, 'Namfix', 'Universal web-enabled attitude', 'Sports', 48544, 2839, true);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (3, 'Tresom', 'Robust web-enabled conglomeration', 'Tech', 19614, 228, false);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (20, 'Kanlam', 'Monitored leading edge paradigm', 'Gaming', 16070, 7532, false);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (12, 'Aerified', 'Future-proofed composite instruction set', 'Food', 6379, 1394, true);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (4, 'Keylex', 'Assimilated national customer loyalty', 'Memes', 90714, 4585, false);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (23, 'Cardify', 'Face to face heuristic benchmark', 'Literature', 13435, 4366, false);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (1, 'Duobam', 'Balanced multi-state structure', 'Literature', 4664, 3614, true);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (12, 'Ventosanzap', 'Self-enabling cohesive encryption', 'Health and Fitness', 66544, 4667, true);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (8, 'Lotlux', 'Profound tertiary conglomeration', 'Science', 77139, 868, true);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (24, 'Zontrax', 'Future-proofed non-volatile groupware', 'Memes', 45602, 9364, false);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (3, 'Alphazap', 'Enterprise-wide even-keeled hub', 'Health and Fitness', 39504, 9176, false);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (18, 'Otcom', 'Organic zero administration methodology', 'Sports', 72337, 7696, false);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (9, 'Fintone', null, 'TV', 63679, null, false);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (23, 'Lotstring', 'Open-source intermediate superstructure', 'News', 24662, 2417, false);
insert into community (id_owner, name, description, tag, icon, banner, is_deleted) values (22, 'Fixflexa', 'Exclusive regional ability', 'Science', 77215, 307, false);

insert into content (id_author, is_post, is_deleted, is_edited) values (1,  true, false, false);
insert into content (id_author, is_post, is_deleted, is_edited) values (2,  true, false, false);
insert into content (id_author, is_post, is_deleted, is_edited) values (7,  true, true, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (4,  false, false, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (2,  false, false, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (6,  false, false, false);
insert into content (id_author, is_post, is_deleted, is_edited) values (15,  false, false, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (19,  true, false, false);
insert into content (id_author, is_post, is_deleted, is_edited) values (9,  false, false, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (10,  false, true, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (10, false, false, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (6,  false, false, false);
insert into content (id_author, is_post, is_deleted, is_edited) values (13,  false, false, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (5, false, false, false);
insert into content (id_author, is_post, is_deleted, is_edited) values (7, false, false, false);
insert into content (id_author, is_post, is_deleted, is_edited) values (3, true, false, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (10, false, true, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (3, true, true, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (1, true, true, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (16, false, false, false);
insert into content (id_author, is_post, is_deleted, is_edited) values (15, false, true, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (1, false, false, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (11, false, false, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (13, true, true, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (4, true, false, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (3, true, false, true);
insert into content (id_author, is_post, is_deleted, is_edited) values (11, false, true, false);
insert into content (id_author, is_post, is_deleted, is_edited) values (2, false, false, false);
insert into content (id_author, is_post, is_deleted, is_edited) values (18, true, true, false);
insert into moderator (id_mod, id_community) values (1, 15);
insert into moderator (id_mod, id_community) values (1, 7);
insert into moderator (id_mod, id_community) values (1, 2);
insert into moderator (id_mod, id_community) values (2, 16);
insert into moderator (id_mod, id_community) values (1, 16);
insert into moderator (id_mod, id_community) values (1, 5);
insert into moderator (id_mod, id_community) values (1, 12);
insert into moderator (id_mod, id_community) values (1, 9);
insert into moderator (id_mod, id_community) values (1, 18);
insert into moderator (id_mod, id_community) values (1, 13);
insert into moderator (id_mod, id_community) values (1, 6);
insert into moderator (id_mod, id_community) values (1, 1);
insert into moderator (id_mod, id_community) values (1, 10);
insert into moderator (id_mod, id_community) values (1, 17);
insert into moderator (id_mod, id_community) values (1, 19);
insert into moderator (id_mod, id_community) values (1, 11);
insert into moderator (id_mod, id_community) values (1, 3);
insert into moderator (id_mod, id_community) values (1, 8);
insert into moderator (id_mod, id_community) values (1, 14);

insert into tag (id_community, name) values (2, 'Discussion');
insert into tag (id_community, name) values (4, 'Mod Post');
insert into tag (id_community, name) values (7, 'Soccer');
insert into tag (id_community, name) values (9, 'Basketball');
insert into tag (id_community, name) values (10, 'Recipe');
insert into tag (id_community, name) values (1, 'Life-Hack');
insert into tag (id_community, name) values (20, 'Motorsports');
insert into tag (id_community, name) values (17, 'Chess');
insert into tag (id_community, name) values (19, 'FPS');
insert into tag (id_community, name) values (16, 'Meme');
insert into tag (id_community, name) values (10, 'Advertisement');
insert into tag (id_community, name) values (15, 'Money');
insert into tag (id_community, name) values (3, 'Jazz');
insert into tag (id_community, name) values (11, 'Rock');
insert into tag (id_community, name) values (12, 'Hip-Hop');
insert into tag (id_community, name) values (13, 'Football');

insert into post (id, id_community, id_tag, title, is_image) values (26, 2, 1, 'Scusa ma ti chiamo amore', false);
insert into post (id, id_community, id_tag, title, is_image) values (18, 4, 2, 'Citizen Kane', false);
insert into post (id, id_community, id_tag, title, is_image) values (20, 7, 3, 'Big Star: Nothing Can Hurt Me', false);
insert into post (id, id_community, id_tag, title, is_image) values (22, 9, 4, 'Together (Tillsammans)', true);
insert into post (id, id_community, id_tag, title, is_image) values (28, 10, 5, 'Grand Seduction, The', false);
insert into post (id, id_community, id_tag, title, is_image) values (14, 1, 6, 'Chechahcos, The', true);
insert into post (id, id_community, id_tag, title, is_image) values (5, 20, 7, 'Ninette', false);
insert into post (id, id_community, id_tag, title, is_image) values (27, 17, 8, 'Babadook, The', false);
insert into post (id, id_community, id_tag, title, is_image) values (23, 19, 9, 'While the City Sleeps', false);
insert into post (id, id_community, id_tag, title, is_image) values (3, 16, 10, 'Trespass', false);
insert into post (id, id_community, id_tag, title, is_image) values (2, 10, 11, 'Sammy and Rosie Get Laid', false);
insert into post (id, id_community, id_tag, title, is_image) values (15, 15, 12, 'Judas Kiss', true);
insert into post (id, id_community, id_tag, title, is_image) values (13, 3, 13, 'Seizure', false);
insert into post (id, id_community, id_tag, title, is_image) values (1, 11, 14, 'Lost Youth', false);
insert into post (id, id_community, id_tag, title, is_image) values (12, 12, 15, 'American Buffalo', false);
insert into post (id, id_community, id_tag, title, is_image) values (29, 16, 10, 'Don''t Deliver Us from Evil (Mais ne nous délivrez pas du mal)', true);
insert into post (id, id_community, id_tag, title, is_image) values (6, 15, 12, 'End of the Game (Der Richter und sein Henker)', false);

insert into text_post (id, text) values (26, 'Realigned secondary analyzer');
insert into text_post (id, text) values (18, 'Ameliorated well-modulated flexibility');
insert into text_post (id, text) values (20, 'Operative well-modulated intranet');
insert into text_post (id, text) values (28, 'Decentralized explicit knowledge user');
insert into text_post (id, text) values (5, 'Object-based executive complexity');
insert into text_post (id, text) values (27, 'Upgradable motivating system engine');
insert into text_post (id, text) values (23, 'Advanced neutral access');
insert into text_post (id, text) values (3, 'Streamlined heuristic concept');
insert into text_post (id, text) values (2, 'Re-engineered mission-critical software');
insert into text_post (id, text) values (13, 'Persistent human-resource extranet');
insert into text_post (id, text) values (1, 'Visionary zero tolerance data-warehouse');
insert into text_post (id, text) values (12, 'Diverse scalable functionalities');
insert into text_post (id, text) values (6, 'Fundamental non-volatile capability');

insert into comment (id, id_parent, text) values (4, 10, 'Reverse-engineered bi-directional budgetary management');
insert into comment (id, id_parent, text) values (5, 8, 'Vision-oriented systematic standardization');
insert into comment (id, id_parent, text) values (6, 15, 'Up-sized 6th generation utilisation');
insert into comment (id, id_parent, text) values (7, 5, 'Open-architected demand-driven toolset');
insert into comment (id, id_parent, text) values (9, 5, 'Function-based clear-thinking artificial intelligence');
insert into comment (id, id_parent, text) values (10, 2, 'Inverse cohesive function');
insert into comment (id, id_parent, text) values (11, 19, 'Adaptive optimizing interface');
insert into comment (id, id_parent, text) values (12, 2, 'Face to face client-server hardware');
insert into comment (id, id_parent, text) values (13, 10, 'Self-enabling coherent analyzer');
insert into comment (id, id_parent, text) values (14, 3, 'Devolved tangible capability');
insert into comment (id, id_parent, text) values (15, 7, 'Synergistic foreground flexibility');
insert into comment (id, id_parent, text) values (17, 19, 'Progressive discrete paradigm');
insert into comment (id, id_parent, text) values (20, 2, 'Seamless global approach');
insert into comment (id, id_parent, text) values (21, 8, 'Monitored static parallelism');
insert into comment (id, id_parent, text) values (22, 2, 'Versatile encompassing groupware');
insert into comment (id, id_parent, text) values (23, 12, 'Synchronised well-modulated complexity');
insert into comment (id, id_parent, text) values (27, 4, 'Programmable human-resource customer loyalty');
insert into comment (id, id_parent, text) values (28, 19, 'Reactive local secured line');

insert into image_post (id, id_image) values (1, 22);
insert into image_post (id, id_image) values (2, 14);
insert into image_post (id, id_image) values (3, 15);
insert into image_post (id, id_image) values (4, 29);

insert into favorite_post (id_post, id_user) values (26, 20);
insert into favorite_post (id_post, id_user) values (18, 30);
insert into favorite_post (id_post, id_user) values (20, 22);
insert into favorite_post (id_post, id_user) values (22, 11);
insert into favorite_post (id_post, id_user) values (28, 29);
insert into favorite_post (id_post, id_user) values (14, 3);
insert into favorite_post (id_post, id_user) values (5, 29);
insert into favorite_post (id_post, id_user) values (27, 6);
insert into favorite_post (id_post, id_user) values (23, 7);
insert into favorite_post (id_post, id_user) values (3, 13);
insert into favorite_post (id_post, id_user) values (2, 1);
insert into favorite_post (id_post, id_user) values (15, 22);
insert into favorite_post (id_post, id_user) values (13, 9);
insert into favorite_post (id_post, id_user) values (1, 24);
insert into favorite_post (id_post, id_user) values (12, 4);

insert into platform_block (id_admin, reason) values (7, 'Intuitive cohesive paradigm');
insert into platform_block (id_admin, reason) values (12, 'Upgradable contextually-based firmware');
insert into platform_block (id_admin, reason) values (11, 'Compatible dynamic analyzer');
insert into platform_block (id_admin, reason) values (6, 'Mandatory asymmetric function');
insert into platform_block (id_admin, reason) values (4, 'Decentralized full-range strategy');
insert into platform_block (id_admin, reason) values (5, 'Total modular focus group');
insert into platform_block (id_admin, reason) values (6, 'Automated national throughput');
insert into platform_block (id_admin, reason) values (1, 'Business-focused zero administration application');
insert into platform_block (id_admin, reason) values (14, 'Cross-group secondary Graphic Interface');
insert into platform_block (id_admin, reason) values (8, 'Enhanced asynchronous methodology');
insert into platform_block (id_admin, reason) values (5, 'Synchronised systematic success');
insert into platform_block (id_admin, reason) values (9, 'Pre-emptive actuating approach');
insert into platform_block (id_admin, reason) values (4, 'Function-based real-time moderator');
insert into platform_block (id_admin, reason) values (12, 'Triple-buffered tangible support');
insert into platform_block (id_admin, reason) values (9, 'Multi-layered fresh-thinking analyzer');
insert into platform_block (id_admin, reason) values (12, 'Reactive needs-based time-frame');
insert into platform_block (id_admin, reason) values (6, 'Universal composite support');
insert into platform_block (id_admin, reason) values (13, 'Proactive 6th generation parallelism');
insert into platform_block (id_admin, reason) values (11, 'Switchable responsive project');
insert into platform_block (id_admin, reason) values (1, 'Open-source reciprocal workforce');

insert into community_block (id_blockee, id_community, reason) values (22, 19, 'Profit-focused methodical infrastructure');
insert into community_block (id_blockee, id_community, reason) values (8, 8, 'Public-key full-range definition');
insert into community_block (id_blockee, id_community, reason) values (22, 7, 'Persevering motivating firmware');
insert into community_block (id_blockee, id_community, reason) values (29, 12, 'Re-engineered stable framework');
insert into community_block (id_blockee, id_community, reason) values (12, 5, 'Open-architected exuding collaboration');
insert into community_block (id_blockee, id_community, reason) values (30, 15, 'Horizontal even-keeled portal');
insert into community_block (id_blockee, id_community, reason) values (10, 5, 'Diverse mission-critical contingency');
insert into community_block (id_blockee, id_community, reason) values (1, 9, 'Up-sized bi-directional project');
insert into community_block (id_blockee, id_community, reason) values (3, 18, 'Seamless modular policy');
insert into community_block (id_blockee, id_community, reason) values (21, 3, 'Grass-roots multimedia core');
insert into community_block (id_blockee, id_community, reason) values (25, 15, 'Synergized non-volatile budgetary management');
insert into community_block (id_blockee, id_community, reason) values (2, 12, 'Grass-roots explicit moratorium');
insert into community_block (id_blockee, id_community, reason) values (5, 10, 'Balanced modular forecast');
insert into community_block (id_blockee, id_community, reason) values (30, 12, 'Focused content-based solution');
insert into community_block (id_blockee, id_community, reason) values (12, 4, 'Virtual cohesive neural-net');
insert into community_block (id_blockee, id_community, reason) values (13, 14, 'Fully-configurable homogeneous paradigm');
insert into community_block (id_blockee, id_community, reason) values (18, 18, 'Synchronised radical artificial intelligence');
insert into community_block (id_blockee, id_community, reason) values (6, 7, 'Streamlined systematic function');
insert into community_block (id_blockee, id_community, reason) values (29, 5, 'Distributed executive workforce');
insert into community_block (id_blockee, id_community, reason) values (20, 17, 'Synergistic next generation help-desk');

insert into report_information (id_content, id_user, reason, reviewed) values (5, 27, 'Hate Speech', true);
insert into report_information (id_content, id_user, reason, reviewed) values (20, 25, 'Explicit Content', true);
insert into report_information (id_content, id_user, reason, reviewed) values (20, 16, 'Sharing Personal Information', true);
insert into report_information (id_content, id_user, reason, reviewed) values (19, 25, 'Misinformation', true);
insert into report_information (id_content, id_user, reason, reviewed) values (27, 2, 'Breaks Rabbit TOS', true);
insert into report_information (id_content, id_user, reason, reviewed) values (9, 7, 'Breaks Community Rules', false);
insert into report_information (id_content, id_user, reason, reviewed) values (23, 28, 'Breaks Community Rules', true);
insert into report_information (id_content, id_user, reason, reviewed) values (1, 27, 'Explicit Content', false);
insert into report_information (id_content, id_user, reason, reviewed) values (22, 14, 'Explicit Content', false);
insert into report_information (id_content, id_user, reason, reviewed) values (19, 30, 'Sharing Personal Information', true);
insert into report_information (id_content, id_user, reason, reviewed) values (15, 14, 'Breaks Rabbit TOS', true);
insert into report_information (id_content, id_user, reason, reviewed) values (22, 24, 'Breaks Rabbit TOS', true);
insert into report_information (id_content, id_user, reason, reviewed) values (14, 25, 'Explicit Content', true);
insert into report_information (id_content, id_user, reason, reviewed) values (24, 13, 'Breaks Community Rules', false);
insert into report_information (id_content, id_user, reason, reviewed) values (19, 19, 'Sharing Personal Information', false);
insert into report_information (id_content, id_user, reason, reviewed) values (7, 10, 'Breaks Community Rules', true);
insert into report_information (id_content, id_user, reason, reviewed) values (18, 15, 'Explicit Content', false);
insert into report_information (id_content, id_user, reason, reviewed) values (14, 21, 'Sharing Personal Information', false);
insert into report_information (id_content, id_user, reason, reviewed) values (3, 8, 'Explicit Content', false);
insert into report_information (id_content, id_user, reason, reviewed) values (6, 16, 'Breaks Community Rules', false);
insert into report_information (id_content, id_user, reason, reviewed) values (17, 24, 'Hate Speech', true);
insert into report_information (id_content, id_user, reason, reviewed) values (16, 17, 'Hate Speech', false);
insert into report_information (id_content, id_user, reason, reviewed) values (21, 22, 'Sharing Personal Information', false);
insert into report_information (id_content, id_user, reason, reviewed) values (4, 21, 'Breaks Rabbit TOS', true);
insert into report_information (id_content, id_user, reason, reviewed) values (16, 10, 'Spam', false);

insert into user_follow_community (id_follower, id_followee) values (2, 4);
insert into user_follow_community (id_follower, id_followee) values (5, 20);
insert into user_follow_community (id_follower, id_followee) values (29, 8);
insert into user_follow_community (id_follower, id_followee) values (16, 20);
insert into user_follow_community (id_follower, id_followee) values (21, 17);
insert into user_follow_community (id_follower, id_followee) values (3, 12);
insert into user_follow_community (id_follower, id_followee) values (27, 10);
insert into user_follow_community (id_follower, id_followee) values (30, 9);
insert into user_follow_community (id_follower, id_followee) values (19, 3);
insert into user_follow_community (id_follower, id_followee) values (26, 17);
insert into user_follow_community (id_follower, id_followee) values (4, 5);
insert into user_follow_community (id_follower, id_followee) values (5, 5);
insert into user_follow_community (id_follower, id_followee) values (18, 10);
insert into user_follow_community (id_follower, id_followee) values (23, 2);
insert into user_follow_community (id_follower, id_followee) values (8, 6);
insert into user_follow_community (id_follower, id_followee) values (2, 14);
insert into user_follow_community (id_follower, id_followee) values (17, 11);
insert into user_follow_community (id_follower, id_followee) values (9, 11);
insert into user_follow_community (id_follower, id_followee) values (25, 6);
insert into user_follow_community (id_follower, id_followee) values (29, 9);

insert into user_follow_user (id_follower, id_followee) values (26, 22);
insert into user_follow_user (id_follower, id_followee) values (2, 22);
insert into user_follow_user (id_follower, id_followee) values (26, 12);
insert into user_follow_user (id_follower, id_followee) values (18, 26);
insert into user_follow_user (id_follower, id_followee) values (16, 24);
insert into user_follow_user (id_follower, id_followee) values (26, 8);
insert into user_follow_user (id_follower, id_followee) values (30, 8);
insert into user_follow_user (id_follower, id_followee) values (22, 3);
insert into user_follow_user (id_follower, id_followee) values (15, 4);
insert into user_follow_user (id_follower, id_followee) values (9, 27);
insert into user_follow_user (id_follower, id_followee) values (2, 5);
insert into user_follow_user (id_follower, id_followee) values (14, 30);
insert into user_follow_user (id_follower, id_followee) values (4, 2);
insert into user_follow_user (id_follower, id_followee) values (11, 30);
insert into user_follow_user (id_follower, id_followee) values (26, 30);
insert into user_follow_user (id_follower, id_followee) values (18, 17);
insert into user_follow_user (id_follower, id_followee) values (7, 25);
insert into user_follow_user (id_follower, id_followee) values (11, 13);
insert into user_follow_user (id_follower, id_followee) values (10, 23);
insert into user_follow_user (id_follower, id_followee) values (8, 1);

insert into content_rate (id_content, id_user, liked) values (19, 10, false);
insert into content_rate (id_content, id_user, liked) values (26, 3, true);
insert into content_rate (id_content, id_user, liked) values (11, 20, true);
insert into content_rate (id_content, id_user, liked) values (24, 9, false);
insert into content_rate (id_content, id_user, liked) values (2, 3, true);
insert into content_rate (id_content, id_user, liked) values (6, 23, false);
insert into content_rate (id_content, id_user, liked) values (7, 13, true);
insert into content_rate (id_content, id_user, liked) values (8, 23, false);
insert into content_rate (id_content, id_user, liked) values (20, 16, false);
insert into content_rate (id_content, id_user, liked) values (9, 1, false);
insert into content_rate (id_content, id_user, liked) values (1, 16, true);
insert into content_rate (id_content, id_user, liked) values (1, 7, false);
insert into content_rate (id_content, id_user, liked) values (19, 5, false);
insert into content_rate (id_content, id_user, liked) values (3, 10, true);
insert into content_rate (id_content, id_user, liked) values (19, 4, false);
insert into content_rate (id_content, id_user, liked) values (18, 19, false);
insert into content_rate (id_content, id_user, liked) values (8, 14, true);
insert into content_rate (id_content, id_user, liked) values (12, 2, true);
insert into content_rate (id_content, id_user, liked) values (18, 27, true);
insert into content_rate (id_content, id_user, liked) values (8, 26, true);
insert into content_rate (id_content, id_user, liked) values (10, 26, true);
insert into content_rate (id_content, id_user, liked) values (18, 29, true);
insert into content_rate (id_content, id_user, liked) values (24, 12, true);
insert into content_rate (id_content, id_user, liked) values (24, 1, true);
insert into content_rate (id_content, id_user, liked) values (11, 5, false);
insert into content_rate (id_content, id_user, liked) values (8, 10, true);
insert into content_rate (id_content, id_user, liked) values (6, 5, false);
insert into content_rate (id_content, id_user, liked) values (18, 1, false);
insert into content_rate (id_content, id_user, liked) values (21, 8, false);