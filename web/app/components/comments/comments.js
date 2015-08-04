import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    Inject
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';

// import { PostList } from 'app/components/common/post-list/post-list';

// Comments component
@Component({
    selector: 'comments',
    hostInjector: [DataService]
})
@View({
    templateUrl: 'app/components/comments/comments.html',
    styleUrls: ['app/components/comments/comments.css'],
    directives: [RouterLink]
})
export class Comments {
    constructor(@Inject(RouteParams) routeParams: RouteParams, dataService: DataService) {
        this.subreddit = routeParams.params.subreddit;
        this.post_id = routeParams.params.post_id;
        // dataService.getSubreddit(this.subreddit).subscribe(function (subreddit) {
        //     this.name = subreddit.name;
        //     this.posts = subreddit.posts;
        // }.bind(this));
    }
}
