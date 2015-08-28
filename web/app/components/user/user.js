import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';
import { PostList } from 'app/components/common/post-list/post-list';
import { CommentList } from 'app/components/common/comment-list/comment-list';

// Subreddit component
@Component({
    selector: 'user',
    bindings: [DataService]
})
@View({
    templateUrl: 'app/components/user/user.html',
    styleUrls: ['app/components/user/user.css'],
    directives: [CommentList, PostList, RouterLink]
})
export class User {
    constructor(dataService: DataService, @Inject(RouteParams) routeParams: RouteParams) {
        this.dataService = dataService;
        this.user = routeParams.params.name;
        this.dataService.getUserSummary(this.user).subscribe(function(user) {
            this.name = user.username;
            this.posts = user.posts;
            this.comments = user.comments;
        }.bind(this));
    }
}
