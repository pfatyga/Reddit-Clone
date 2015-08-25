CREATE TABLE user(
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    is_admin BIT,
    PRIMARY KEY (username)
);

CREATE TABLE subreddit(
    name VARCHAR(255) NOT NULL,
    when_created DATE,
    PRIMARY KEY (name)
);

CREATE TABLE post(
    post_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    when_created DATE NOT NULL,
    author VARCHAR(255) NOT NULL,
    subreddit VARCHAR(255) NOT NULL,
    PRIMARY KEY (post_id),
    FOREIGN KEY (author) REFERENCES user(username),
    FOREIGN KEY (subreddit) REFERENCES subreddit(name)
);

CREATE TABLE comment(
    comment_id INT NOT NULL AUTO_INCREMENT,
    content TEXT NOT NULL,
    when_created DATE NOT NULL,
    author VARCHAR(255) NOT NULL,
    post_id INT NOT NULL,
    parent_comment_id INT,
    PRIMARY KEY (comment_id),
    FOREIGN KEY (author) REFERENCES user(username),
    FOREIGN KEY (post_id) REFERENCES post(post_id),
    FOREIGN KEY (parent_comment_id) REFERENCES comment(comment_id)
);

CREATE TABLE user_post_vote(
    username VARCHAR(255) NOT NULL,
    post_id INT NOT NULL,
    type BIT,
    PRIMARY KEY (username, post_id),
    FOREIGN KEY (username) REFERENCES user(username),
    FOREIGN KEY (post_id) REFERENCES post(post_id)
);

CREATE TABLE user_comment_vote(
    username VARCHAR(255) NOT NULL,
    comment_id INT NOT NULL,
    type BIT,
    PRIMARY KEY (username, comment_id),
    FOREIGN KEY (username) REFERENCES user(username),
    FOREIGN KEY (comment_id) REFERENCES comment(comment_id)
);

CREATE TABLE user_subreddit_subscription(
    username VARCHAR(255) NOT NULL,
    subreddit_name VARCHAR(255) NOT NULL,
    PRIMARY KEY (username, subreddit_name),
    FOREIGN KEY (username) REFERENCES user(username),
    FOREIGN KEY (subreddit_name) REFERENCES subreddit(name)
);

CREATE TABLE user_subreddit_moderator(
    username VARCHAR(255) NOT NULL,
    subreddit_name VARCHAR(255) NOT NULL,
    PRIMARY KEY (username, subreddit_name),
    FOREIGN KEY (username) REFERENCES user(username),
    FOREIGN KEY (subreddit_name) REFERENCES subreddit(name)
);
