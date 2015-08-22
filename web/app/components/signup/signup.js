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
import { host } from 'app/services/dataService';

// Signup component
@Component({
    selector: 'signup',
    hostInjector: [FormBuilder],//, DataService],
    viewBindings: [
        FormBuilder
    ]
})
@View({
    templateUrl: 'app/components/signup/signup.html',
    styleUrls: ['app/components/signup/signup.css'],
    directives: [FORM_DIRECTIVES]
})

export class Signup {
    signupForm;
    constructor(builder: FormBuilder) {
        this.signupForm = builder.group({
            'email':    ['', Validators.required],
            'username': ['', Validators.required],
            'password': ['', Validators.required]
        });
    }
}
