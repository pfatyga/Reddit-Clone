import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject,
    NgIf
} from 'angular2/angular2';
import { Router, RouteParams, RouterLink } from 'angular2/router';
import {
    FormBuilder,
    Validators,
    FORM_DIRECTIVES,
    ControlGroup,
    forms
} from 'angular2/forms';
import { DataService } from 'app/services/dataService';

import { CommentList } from 'app/components/common/comment-list/comment-list';

// Comments component
@Component({
    selector: 'comments',
    hostInjector: [FormBuilder],
    viewBindings: [
        FormBuilder
    ],
    bindings: [DataService]
})
@View({
    templateUrl: 'app/components/comments/comments.html',
    styleUrls: ['app/components/comments/comments.css'],
    directives: [FORM_DIRECTIVES, NgIf, CommentList, RouterLink]
})
export class Comments {
    loading;
    replyForm;
    constructor(dataService: DataService, router: Router, @Inject(RouteParams) routeParams: RouteParams, builder: FormBuilder) {
        this.dataService = dataService;
        this.loading = true;
        this.router = router;
        this.subreddit = routeParams.params.subreddit;
        this.post_id = routeParams.params.post_id;
        this.replyForm = builder.group({
            'content':  ['', Validators.required],
        });

        this.refresh();

    }

    refresh() {
        this.dataService.getPost(this.subreddit, this.post_id).subscribe(function (post) {
            this.post = post;
            this.title = post.title;
            this.content = post.content;
            this.author = post.author;
            this.date = post.when_created;
            this.upVotes = post.upVotes;
            this.downVotes = post.downVotes;
            this.comments = post.comments;
            this.loading = false;
        }.bind(this));
    }



    submit() {
        this.dataService.replyPost(this.subreddit, this.post_id, this.replyForm.controls.content.value).then(function (result) {
            if(result.status === 200) {
                this.refresh();
            } else if(result.status === 401) {
                this.router.parent.navigate('/login');
            }
        }.bind(this), function(err) {
            this.message = 'An error occurred: ' + JSON.stringify(err);
        }.bind(this));
    }

}
