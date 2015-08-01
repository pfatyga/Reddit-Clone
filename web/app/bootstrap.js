// Angular
import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    bootstrap,
    bind,
    BrowserLocation
} from 'angular2/angular2';

// Router
import {
    RouteConfig,
    RouterOutlet,
    Router,
    routerInjectables,
    LocationStrategy,
    HashLocationStrategy,
    HTML5LocationStrategy,
    Location
} from 'angular2/router';

// http
import { httpInjectables } from 'angular2/http';

// Components
import { App } from 'app/components/app/app';

/*
// App component
@Component({
    selector: 'app'
})
@View({
      template: `<router-outlet></router-outlet>`,
      directives: [RouterOutlet]
})
@RouteConfig([
    { path: '/', redirectTo: '/front' },
    { path: '/front', as: 'front',  component: Front },
    { path: '/user', as: 'user',  component: User },
])
export class App {
    constructor(router:Router, location:Location) {
        this.router = router;
        this.location = location;
        this.name = 'Alice';
    }
}*/

bootstrap(App, [
    httpInjectables,
    routerInjectables,
    bind(LocationStrategy).toClass(HTML5LocationStrategy)
]);
