import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    Inject,
    NgFor
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';

import { PostItem } from 'app/components/common/post-list/post-item';

// PostList component
@Component({
    selector: 'post-list',
    properties: ['posts']
})
@View({
    templateUrl: 'app/components/common/post-list/post-list.html',
    styleUrls: ['app/components/common/post-list/post-list.css'],
    directives: [PostItem, NgFor, RouterLink]
})
export class PostList {
    constructor() {
    }
}
