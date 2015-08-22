import {
    ComponentMetadata as Component,
    ViewMetadata as View
} from 'angular2/angular2';
import {
    FormBuilder,
    Validators,
    FORM_DIRECTIVES,
    ControlGroup,
    forms
} from 'angular2/forms';
import { DataService } from 'app/services/dataService';

// Login component
@Component({
    selector: 'login',
    hostInjector: [FormBuilder, DataService],
    viewBindings: [
        FormBuilder
    ]
})
@View({
    templateUrl: 'app/components/login/login.html',
    styleUrls: ['app/components/login/login.css'],
    directives: [FORM_DIRECTIVES]
})

export class Login {
    loginForm;
    constructor(builder: FormBuilder, dataService: DataService) {
        this.loginForm = builder.group({
            'username': ['', Validators.required],
            'password': ['', Validators.required]
        });
    }
}
