import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    Inject
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';

// PostItem component
@Component({
    selector: 'post-item',
    properties: ['post']
})
@View({
    templateUrl: 'app/components/common/post-list/post-item.html',
    styleUrls: ['app/components/common/post-list/post-item.css'],
    directives: [RouterLink]
})
export class PostItem {

    constructor() {
    }

    voteUp() {
        this.post.numUpvotes++;
    }

    voteDown() {
        this.post.numDownvotes++;
    }
}
