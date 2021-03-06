import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    NgFor
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';

import { CommentItem } from 'app/components/common/comment-list/comment-item';

@Component({
    selector: 'comment-list',
    properties: ['comments']
})
@View({
    templateUrl: 'app/components/common/comment-list/comment-list.html',
    styleUrls: ['app/components/common/comment-list/comment-list.css'],
    directives: [CommentList, CommentItem, NgFor, RouterLink]
})
export class CommentList {
    constructor() {
    }
}
