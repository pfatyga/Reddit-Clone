// Angular
import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    CSSClass
} from 'angular2/angular2';

// Router
import {
    RouteConfig,
    RouterOutlet,
    Router,
    RouterLink,
    Location
} from 'angular2/router';

// Components
import { Home } from 'app/components/home/home';
import { Login } from 'app/components/login/login';
import { Subreddit } from 'app/components/subreddit/subreddit';
import { User } from 'app/components/user/user';
import { Comments } from 'app/components/comments/comments';

// App component
@Component({
    selector: 'app'
})
@View({
    templateUrl: 'app/components/app/app.html',
    styleUrls: ['app/components/app/app.css'],
    directives: [CSSClass, RouterOutlet, RouterLink, Login]
})
@RouteConfig([
    { path: '/',                        as: 'home',         component: Home },
    { path: '/r/:name',                 as: 'subreddit',    component: Subreddit },
    { path: '/r/:subreddit/:post_id',   as: 'comments',     component: Comments },
    { path: '/u/:name',                 as: 'user',         component: User }
])
export class App {
    showLogin;
    constructor(router:Router, location:Location) {
        this.router = router;
        this.location = location;
        this.user = null;
        this.showLogin = false;
    }

    toggleLogin() {
        this.showLogin = !this.showLogin;
    }
}
