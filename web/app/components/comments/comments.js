import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject
} from 'angular2/angular2';
import { Http } from 'http/http';
import { RouteParams, RouterLink } from 'angular2/router';
import { host } from 'app/services/dataService';

import { CommentList } from 'app/components/common/comment-list/comment-list';

// Comments component
@Component({
    selector: 'comments'
})
@View({
    templateUrl: 'app/components/comments/comments.html',
    styleUrls: ['app/components/comments/comments.css'],
    directives: [CommentList, RouterLink]
})
export class Comments {
    constructor(@Inject(RouteParams) routeParams: RouteParams, http: Http) {
        this.http = http;
        this.subreddit = routeParams.params.subreddit;
        this.post_id = routeParams.params.post_id;
        this.author = 'author';
        this.title = 'Title';
        this.content = 'Content';
        this.getPost(this.subreddit, this.post_id).subscribe(function (post) {
            this.post = post;
            this.title = post.title;
            this.content = post.content;
            this.author = post.posted_by;
            this.date = post.when_created;
            this.upvotes = post.numUpvotes;
            this.downvotes = post.numDownvotes;
            this.comments = post.comments;
        }.bind(this));
    }

    getPost(subreddit, post_id) {
        return this.http.get(host + '/api/subreddits/' + subreddit + '/posts/' + post_id)
            .toRx()
            .map(res => res.json());
    }

}
