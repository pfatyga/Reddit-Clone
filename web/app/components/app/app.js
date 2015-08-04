// Angular
import {
    ComponentAnnotation as Component,
    ViewAnnotation as View
} from 'angular2/angular2';

// Router
import {
    RouteConfig,
    RouterOutlet,
    Router,
    Location
} from 'angular2/router';

// Components
import { Home } from 'app/components/home/home';
import { Subreddit } from 'app/components/subreddit/subreddit';
import { User } from 'app/components/user/user';

// App component
@Component({
    selector: 'app'
})
@View({
    templateUrl: 'app/components/app/app.html',
    styleUrls: ['app/components/app/app.css'],
    directives: [RouterOutlet]
})
@RouteConfig([
    { path: '/',        as: 'home',         component: Home },
    { path: '/r/:name', as: 'subreddit',    component: Subreddit },
    { path: '/u/:name', as: 'user',         component: User }
])
export class App {
    constructor(router:Router, location:Location) {
        this.router = router;
        this.location = location;
    }
}
