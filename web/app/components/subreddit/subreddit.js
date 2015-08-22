import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';

import { PostList } from 'app/components/common/post-list/post-list';
import { Sidebar } from 'app/components/common/sidebar/sidebar';

// Subreddit component
@Component({
    selector: 'subreddit',
    hostInjector: [DataService]
})
@View({
    templateUrl: 'app/components/subreddit/subreddit.html',
    styleUrls: ['app/components/subreddit/subreddit.css'],
    directives: [PostList, Sidebar, RouterLink]
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
