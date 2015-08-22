import {
    ComponentMetadata as Component,
    ViewMetadata as View
} from 'angular2/angular2';
import { RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';

import { PostList } from 'app/components/common/post-list/post-list';
import { Sidebar } from 'app/components/common/sidebar/sidebar';

// Home component
@Component({
    selector: 'home',
    hostInjector: [DataService]
})
@View({
    templateUrl: 'app/components/home/home.html',
    styleUrls: ['app/components/home/home.css'],
    directives: [PostList, Sidebar, RouterLink]
})
export class Home {
    constructor(dataService: DataService) {
        dataService.getFrontPage().subscribe(posts => this.posts = posts);
    }
}
