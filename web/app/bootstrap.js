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

bootstrap(App, [
    httpInjectables,
    routerInjectables,
    bind(LocationStrategy).toClass(HTML5LocationStrategy)
]);
