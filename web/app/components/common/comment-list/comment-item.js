import {
    ComponentMetadata as Component,
    ViewMetadata as View,
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
import { Comments } from 'app/components/comments/comments';


@Component({
    selector: 'comment-item',
    properties: ['comment'],
    hostInjector: [FormBuilder],
    viewBindings: [
        FormBuilder
    ],
    bindings: [DataService]
})
@View({
    templateUrl: 'app/components/common/comment-list/comment-item.html',
    styleUrls: ['app/components/common/comment-list/comment-item.css'],
    directives: [FORM_DIRECTIVES, RouterLink, NgIf]
})
export class CommentItem {
    reply;
    replyForm;
    constructor(dataService: DataService, router: Router, builder: FormBuilder, comments: Comments) {
        this.postInfo = comments;
        this.reply = false;
        this.dataService = dataService;
        this.router = router;
        this.replyForm = builder.group({
            'content':  ['', Validators.required],
        });
    }

    toggleReply() {
        this.reply = !this.reply;
    }

    submit() {
        this.dataService.replyComment(this.postInfo.subreddit, this.postInfo.post_id, this.comment.comment_id, this.replyForm.controls.content.value).then(function (result) {
            if(result.status === 200) {
                var comment = result.json();
                this.comment.children = this.comment.children || [];
                this.comment.children.push(comment);
            } else if(result.status === 401) {
                this.router.parent.navigate('/login');
            }
        }.bind(this), function(err) {
            this.message = 'An error occurred: ' + JSON.stringify(err);
        }.bind(this));
    }

}
