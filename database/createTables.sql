    DROP TABLE IF EXISTS user;
    CREATE TABLE user(
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255),
        is_admin BIT,
        PRIMARY KEY (username)
    );

    DROP TABLE IF EXISTS subreddit;
    CREATE TABLE subreddit(
        name VARCHAR(255) NOT NULL,
        timestamp DATETIME NOT NULL,
        PRIMARY KEY (name)
    );

    DROP TABLE IF EXISTS post;
    CREATE TABLE post(
        post_id INT NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        url VARCHAR(255),
        imageUrl VARCHAR(255),
        timestamp DATETIME NOT NULL,
        author VARCHAR(255) NOT NULL,
        subreddit VARCHAR(255) NOT NULL,
        PRIMARY KEY (post_id),
        FOREIGN KEY (author) REFERENCES user(username),
        FOREIGN KEY (subreddit) REFERENCES subreddit(name)
    );

    DROP TABLE IF EXISTS comment;
    CREATE TABLE comment(
        comment_id INT NOT NULL AUTO_INCREMENT,
        content TEXT NOT NULL,
        timestamp DATETIME NOT NULL,
        author VARCHAR(255) NOT NULL,
        post_id INT NOT NULL,
        parent_comment_id INT,
        PRIMARY KEY (comment_id),
        FOREIGN KEY (author) REFERENCES user(username),
        FOREIGN KEY (post_id) REFERENCES post(post_id)
    );

    DROP TABLE IF EXISTS user_post_vote;
    CREATE TABLE user_post_vote(
        username VARCHAR(255) NOT NULL,
        post_id INT NOT NULL,
        type BIT,
        PRIMARY KEY (username, post_id),
        FOREIGN KEY (username) REFERENCES user(username),
        FOREIGN KEY (post_id) REFERENCES post(post_id)
    );

    DROP TABLE IF EXISTS user_comment_vote;
    CREATE TABLE user_comment_vote(
        username VARCHAR(255) NOT NULL,
        comment_id INT NOT NULL,
        type BIT,
        PRIMARY KEY (username, comment_id),
        FOREIGN KEY (username) REFERENCES user(username),
        FOREIGN KEY (comment_id) REFERENCES comment(comment_id)
    );

    DROP TABLE IF EXISTS user_subreddit_subscription;
    CREATE TABLE user_subreddit_subscription(
        username VARCHAR(255) NOT NULL,
        subreddit VARCHAR(255) NOT NULL,
        PRIMARY KEY (username, subreddit),
        FOREIGN KEY (username) REFERENCES user(username),
        FOREIGN KEY (subreddit) REFERENCES subreddit(name)
    );

    DROP TABLE IF EXISTS user_subreddit_moderator;
    CREATE TABLE user_subreddit_moderator(
        username VARCHAR(255) NOT NULL,
        subreddit VARCHAR(255) NOT NULL,
        PRIMARY KEY (username, subreddit),
        FOREIGN KEY (username) REFERENCES user(username),
        FOREIGN KEY (subreddit) REFERENCES subreddit(name)
    );
