import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    Inject,
    NgFor
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';

// Sidebar component
@Component({
    selector: 'sidebar'
})
@View({
    templateUrl: 'app/components/common/sidebar/sidebar.html',
    styleUrls: ['app/components/common/sidebar/sidebar.css'],
    directives: [NgFor, RouterLink]
})
export class Sidebar {
    constructor() {
    }
}
