import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';

import { CommentList } from 'app/components/common/comment-list/comment-list';

// Comments component
@Component({
    selector: 'comments',
    hostInjector: [DataService]
})
@View({
    templateUrl: 'app/components/comments/comments.html',
    styleUrls: ['app/components/comments/comments.css'],
    directives: [CommentList, RouterLink]
})
export class Comments {
    constructor(@Inject(RouteParams) routeParams: RouteParams, dataService: DataService) {
        this.subreddit = routeParams.params.subreddit;
        this.post_id = routeParams.params.post_id;
        this.author = 'author';
        this.title = 'Title';
        this.content = 'Content';
        dataService.getPost(this.subreddit, this.post_id).subscribe(function (post) {
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
}
