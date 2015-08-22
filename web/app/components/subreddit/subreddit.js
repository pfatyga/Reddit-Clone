import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';

import { Http } from 'http/http';
import { host } from 'app/services/dataService';

import { PostList } from 'app/components/common/post-list/post-list';
import { Sidebar } from 'app/components/common/sidebar/sidebar';

// Subreddit component
@Component({
    selector: 'subreddit'
})
@View({
    templateUrl: 'app/components/subreddit/subreddit.html',
    styleUrls: ['app/components/subreddit/subreddit.css'],
    directives: [PostList, Sidebar, RouterLink]
})
export class Subreddit {

    constructor(@Inject(RouteParams) routeParams: RouteParams, http: Http) {
        this.subreddit = routeParams.params.name;
        this.http = http;
        this.getSubreddit(this.subreddit).subscribe(function (subreddit) {
            this.name = subreddit.name;
            this.posts = subreddit.posts;
        }.bind(this));
    }

    getSubreddit(name) {
        return this.http.get(host + '/api/subreddits/' + name)
            .toRx()
            .map(res => res.json());
    }

}
