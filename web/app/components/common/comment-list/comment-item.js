import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    NgFor
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';

@Component({
    selector: 'comment-item',
    properties: ['comment']
})
@View({
    templateUrl: 'app/components/common/comment-list/comment-item.html',
    styleUrls: ['app/components/common/comment-list/comment-item.css'],
    directives: [NgFor, RouterLink]
})
export class CommentItem {
    constructor() {
    }
}
