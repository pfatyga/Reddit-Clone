import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject
} from 'angular2/angular2';
import { Router, RouteParams, RouterLink } from 'angular2/router';
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

    constructor(dataService: DataService, router: Router) {
        this.dataService = dataService;
        this.router = router;
    }

    voteUp() {
        this.dataService.upVotePost(this.post.subreddit, this.post.post_id).then(function (result) {
            if(result.status === 200) {
                var post = result.json();
                this.post.upVotes = post.upVotes;
                this.post.downVotes = post.downVotes;
            } else if(result.status === 401) {
                this.router.parent.navigate('/login');
            }
        }.bind(this));
    }

    voteDown() {
        this.dataService.downVotePost(this.post.subreddit, this.post.post_id).then(function (result) {
            if(result.status === 200) {
                var post = result.json();
                this.post.upVotes = post.upVotes;
                this.post.downVotes = post.downVotes;
            } else if(result.status === 401) {
                this.router.parent.navigate('/login');
            }
        }.bind(this));
    }
}
