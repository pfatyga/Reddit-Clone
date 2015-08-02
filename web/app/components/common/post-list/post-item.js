import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    Inject,
    NgFor
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';

// PostItem component
@Component({
    selector: 'post-item',
    properties: ['post']
})
@View({
    templateUrl: 'app/components/common/post-list/post-item.html',
    directives: [NgFor, RouterLink]
})
export class PostItem {
    constructor() {
    }
}
