import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject
} from 'angular2/angular2';
import { Router, RouteParams, RouterLink } from 'angular2/router';
import { Http } from 'http/http';
import { DataService } from 'app/services/dataService';

// PostItem component
@Component({
    selector: 'post-item',
    properties: ['post'],
    bindings: [DataService]
})
@View({
    templateUrl: 'app/components/common/post-list/post-item.html',
    styleUrls: ['app/components/common/post-list/post-item.css'],
    directives: [RouterLink]
})
export class PostItem {

    constructor(router: Router, http: Http) {
        this.router = router;
        this.http = http;
    }

    voteUp() {
        this.post.upVotes++;
    }

    voteDown() {
        this.post.downVotes++;
    }
}
