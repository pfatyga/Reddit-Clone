import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject,
    NgIf
} from 'angular2/angular2';
import { Http } from 'http/http';
import { Router, RouteParams, RouterLink } from 'angular2/router';
import {
    FormBuilder,
    Validators,
    FORM_DIRECTIVES,
    ControlGroup,
    forms
} from 'angular2/forms';
import { host } from 'app/services/dataService';

import { CommentList } from 'app/components/common/comment-list/comment-list';

// Comments component
@Component({
    selector: 'comments',
    hostInjector: [FormBuilder],//, DataService],
    viewBindings: [
        FormBuilder
    ]
})
@View({
    templateUrl: 'app/components/comments/comments.html',
    styleUrls: ['app/components/comments/comments.css'],
    directives: [FORM_DIRECTIVES, NgIf, CommentList, RouterLink]
})
export class Comments {
    loading;
    replyForm;
    constructor(router: Router, @Inject(RouteParams) routeParams: RouteParams, builder: FormBuilder,  http: Http) {
        this.loading = true;
        this.router = router;
        this.http = http;
        this.subreddit = routeParams.params.subreddit;
        this.post_id = routeParams.params.post_id;
        this.replyForm = builder.group({
            'content':  ['', Validators.required],
        });

        this.refresh();

    }

    refresh() {
        this.getPost(this.subreddit, this.post_id).subscribe(function (post) {
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

    getPost(subreddit, post_id) {
        return this.http.get(host + '/api/subreddits/' + subreddit + '/posts/' + post_id)
            .toRx()
            .map(res => res.json());
    }

    submitReply(content) {
        return this.http.post(host + '/api/subreddits/' + this.subreddit + '/posts/' + this.post_id + '/new',
            'content=' + content, {
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
            .toRx()
            .toPromise();
    }

    submit() {
        this.submitReply(this.replyForm.controls.content.value).then(function (result) {
            if(result.status == 200) {
                this.refresh();
            } else {
                this.router.parent.navigate('/login');
            }
        }.bind(this), function(err) {
            this.message = 'An error occurred: ' + JSON.stringify(err);
        }.bind(this));
    }

}
