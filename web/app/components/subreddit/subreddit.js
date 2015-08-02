import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    Inject,
    NgFor
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';

import { PostList } from 'app/components/common/post-list/post-list';

// Subreddit component
@Component({
    selector: 'subreddit',
    hostInjector: [DataService]
})
@View({
    templateUrl: 'app/components/subreddit/subreddit.html',
    directives: [PostList, NgFor, RouterLink]
})
export class Subreddit {
    constructor(@Inject(RouteParams) routeParams: RouteParams, dataService: DataService) {
        this.subreddit = routeParams.params.name;
        dataService.getSubreddit(this.subreddit).subscribe(function (subreddit) {
            this.name = subreddit.name;
            this.posts = subreddit.posts;
        }.bind(this));
    }
}
