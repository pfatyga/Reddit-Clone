import {
    ComponentMetadata as Component,
    ViewMetadata as View,
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
        this.post.upVotes++;
    }

    voteDown() {
        this.post.downVotes++;
    }
}
