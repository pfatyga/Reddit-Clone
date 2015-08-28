import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject,
    NgIf
} from 'angular2/angular2';
import { Router, RouteParams, RouterLink } from 'angular2/router';

import { DataService } from 'app/services/dataService';

import { PostList } from 'app/components/common/post-list/post-list';
import { Sidebar } from 'app/components/common/sidebar/sidebar';

// Subreddit component
@Component({
    selector: 'subreddit',
    bindings: [DataService]
})
@View({
    templateUrl: 'app/components/subreddit/subreddit.html',
    styleUrls: ['app/components/subreddit/subreddit.css'],
    directives: [NgIf, PostList, Sidebar, RouterLink]
})
export class Subreddit {
    exists;
    name;
    posts;
    moderators;
    numSubscribers;

    constructor(dataService: DataService, router: Router, @Inject(RouteParams) routeParams: RouteParams) {
        this.dataService = dataService;
        this.subreddit = routeParams.params.name;
        this.router = router;
        this.refresh();
    }

    refresh() {
        this.dataService.getSubreddit(this.subreddit).then(function (result) {
            if(result.status == 200) {
                var subreddit = result.json();
                this.name = subreddit.name;
                this.posts = subreddit.posts;
                this.moderators = subreddit.moderators;
                this.numSubscribers = subreddit.numSubscribers;
                this.exists = true;
            } else {
                this.exists = false;
            }

        }.bind(this));
    }

    click() {
        this.dataService.createSubreddit(this.subreddit).then(function (result) {
            this.refresh();
        }.bind(this));
    }

}
