import { Http } from 'http/http';

export class DataService {

    constructor(http: Http) {
        this.host = '';//'http://private-8dc259-redditclone.apiary-mock.com';
        this.http = http;
    }

    submitPost(subreddit, title, content, url, imageUrl) {
        return this.http.post(this.host + '/api/subreddits/' + subreddit + '/new',
            'title=' + title + '&content=' + content + '&url=' + url + '&imageUrl=' + imageUrl, {
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
            .toRx()
            .toPromise();
    }

    //returns user session
    getUser() {
        return this.http.get(this.host + '/api/authenticateSession')
            .toRx()
            .toPromise();
    }

    login(username, password) {
        return this.http.post(this.host + '/api/login', 'username=' + username + '&password=' + password, {headers: {
            'Content-type': 'application/x-www-form-urlencoded'
        }})
            .toRx()
            .toPromise();
    }

    logout() {
        return this.http.get(this.host + '/api/logout')
            .toRx()
            .toPromise();
    }

    signup(username, password, email) {
        return this.http.post(this.host + '/api/signup', 'username=' + username + '&password=' + password + '&email=' + email, {headers: {
            'Content-type': 'application/x-www-form-urlencoded'
        }})
            .toRx()
            .toPromise();
    }

    //Gets a post with comments
    getPost(subreddit, post_id) {
        return this.http.get(this.host + '/api/subreddits/' + subreddit + '/posts/' + post_id)
            .toRx()
            .map(res => res.json());
    }

    //reply to post
    replyPost(subreddit, post_id, content) {
        return this.http.post(this.host + '/api/subreddits/' + subreddit + '/posts/' + post_id + '/new',
            'content=' + content, {
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
            .toRx()
            .toPromise();
    }

    //reply to comment
    replyComment(subreddit, post_id, comment_id, content) {
        return this.http.post(this.host + '/api/subreddits/' + subreddit + '/posts/' + post_id + '/comments/' + comment_id + '/new',
            'content=' + content, {
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
            .toRx()
            .toPromise();
    }

    getFrontPage() {
        return this.http.get(this.host + '/api/posts')
            .toRx()
            .map(res => res.json());
    }


    // subreddit
    getSubreddit(name) {
        return this.http.get(this.host + '/api/subreddits/' + name)
            .toRx()
            .toPromise();
    }

    createSubreddit(name) {
        return this.http.post(this.host + '/api/subreddits/' + name + '/create')
            .toRx()
            .toPromise();
    }

    // user
    getUserSummary(name) {
        return this.http.get(this.host + '/api/users/' + name)
            .toRx()
            .map(res => res.json());
    }

    // post-item
    upVotePost(subreddit, post_id) {
        return this.http.post(this.host + '/api/subreddits/' + subreddit + '/posts/' + post_id + '/upvote')
            .toRx()
            .toPromise();
    }

    downVotePost(subreddit, post_id) {
        return this.http.post(this.host + '/api/subreddits/' + subreddit + '/posts/' + post_id + '/downvote')
            .toRx()
            .toPromise();
    }

    // comment-item
    upVoteComment(subreddit, post_id, comment_id) {
        return this.http.post(this.host + '/api/subreddits/' + subreddit + '/posts/' + post_id + '/comments/' + comment_id + '/upvote')
            .toRx()
            .toPromise();
    }

    downVoteComment(subreddit, post_id, comment_id) {
        return this.http.post(this.host + '/api/subreddits/' + subreddit + '/posts/' + post_id + '/comments/' + comment_id + '/downvote')
            .toRx()
            .toPromise();
    }

};
