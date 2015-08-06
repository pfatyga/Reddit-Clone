import {
    ComponentAnnotation as Component,
    ViewAnnotation as View
} from 'angular2/angular2';
import { RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';

import { PostList } from 'app/components/common/post-list/post-list';

// Home component
@Component({
    selector: 'home',
    hostInjector: [DataService]
})
@View({
    templateUrl: 'app/components/home/home.html',
    styleUrls: ['app/components/home/home.css'],
    directives: [PostList, RouterLink]
})
export class Home {
    constructor(dataService: DataService) {
        dataService.getFrontPage().subscribe(posts => this.posts = posts);
    }
}
