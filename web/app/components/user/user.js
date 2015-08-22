import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';
import { Http } from 'http/http';
import { host } from 'app/services/dataService';
import { PostList } from 'app/components/common/post-list/post-list';
import { CommentList } from 'app/components/common/comment-list/comment-list';

// Subreddit component
@Component({
    selector: 'user'
})
@View({
    templateUrl: 'app/components/user/user.html',
    styleUrls: ['app/components/user/user.css'],
    directives: [CommentList, PostList, RouterLink]
})
export class User {

    constructor(@Inject(RouteParams) routeParams: RouteParams, http: Http) {
        this.http = http;
        this.user = routeParams.params.name;
        this.getUser(this.user).subscribe(function(user) {
            this.posts = user.posts;
            this.comments = user.comments;
            this.name = user.username;
        }.bind(this));
    }

    getUser(name) {
        return this.http.get(host + '/api/users/' + name)
            .toRx()
            .map(res => res.json());
    }

}
