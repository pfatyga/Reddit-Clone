// Angular
import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    NgIf
} from 'angular2/angular2';

// Router
import {
    RouteConfig,
    RouterOutlet,
    Router,
    RouterLink,
    Location
} from 'angular2/router';

import { Http } from 'http/http';
import { host } from 'app/services/dataService';

// Components
import { Home } from 'app/components/home/home';
import { Login } from 'app/components/login/login';
import { Signup } from 'app/components/signup/signup';
import { Subreddit } from 'app/components/subreddit/subreddit';
import { Post } from 'app/components/post/post';
import { User } from 'app/components/user/user';
import { Comments } from 'app/components/comments/comments';

// App component
@Component({
    selector: 'app'
})
@View({
    templateUrl: 'app/components/app/app.html',
    styleUrls: ['app/components/app/app.css'],
    directives: [NgIf, RouterOutlet, RouterLink, Login]
})
@RouteConfig([
    { path: '/',                        as: 'home',         component: Home },
    { path: '/r/:name',                 as: 'subreddit',    component: Subreddit },
    { path: '/r/:subreddit/newPost',    as: 'post',         component: Post },
    { path: '/r/:subreddit/:post_id',   as: 'comments',     component: Comments },
    { path: '/u/:name',                 as: 'user',         component: User },
    { path: '/login',                   as: 'login',        component: Login },
    { path: '/signup',                  as: 'signup',       component: Signup }
])
export class App {
    user;
    constructor(router: Router, location: Location, http: Http) {
        this.router = router;
        this.location = location;
        this.http = http;
        this.getUser();
    }

    login(userInfo) {
        this.user = userInfo;
    }

    getUser() {
        // call /api/getUser and set this.user to result
        this.http.get(host + '/api/authenticateSession')
            .toRx()
            .toPromise()
            .then(function (ret) {
                if(ret.status == 200) {
                    var user = ret.json();
                    this.user = user;
                }
            }.bind(this));
    }

}
