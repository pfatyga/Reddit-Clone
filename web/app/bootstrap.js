// Angular
import {
    ComponentMetadata as Component,
    ViewMetadata as View,
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
import { HTTP_BINDINGS } from 'http/http';

// Components
import { App } from 'app/components/app/app';

bootstrap(App, [
    HTTP_BINDINGS,
    routerInjectables,
    bind(LocationStrategy).toClass(HTML5LocationStrategy)
]);
