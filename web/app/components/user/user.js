import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    Inject,
    NgFor
} from 'angular2/angular2';
import { RouteParams, RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';

// Subreddit component
@Component({
    selector: 'user',
    hostInjector: [DataService]
})
@View({
    templateUrl: 'app/components/user/user.html',
    directives: [NgFor, RouterLink]
})
export class User {
    constructor(@Inject(RouteParams) routeParams: RouteParams, dataService: DataService) {
        this.user = routeParams.params.name;
        dataService.getUser(this.user).subscribe(function (user) {
            this.posts = user.posts;
        });
    }
}
