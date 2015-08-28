import {
    ComponentMetadata as Component,
    ViewMetadata as View
} from 'angular2/angular2';
import { Location } from 'angular2/router';
import {
    FormBuilder,
    Validators,
    FORM_DIRECTIVES,
    ControlGroup,
    forms
} from 'angular2/forms';
import { DataService } from 'app/services/dataService';
import { App } from 'app/components/app/app';

// Signup component
@Component({
    selector: 'signup',
    hostInjector: [FormBuilder],//, DataService],
    viewBindings: [
        FormBuilder
    ],
    bindings: [DataService]
})
@View({
    templateUrl: 'app/components/signup/signup.html',
    styleUrls: ['app/components/signup/signup.css'],
    directives: [FORM_DIRECTIVES]
})

export class Signup {
    signupForm;
    message;
    constructor(dataService: DataService, app: App, location: Location, builder: FormBuilder) {
        this.dataService = dataService;
        this.app = app;
        this.location = location;
        this.message = '';
        this.signupForm = builder.group({
            'email':    ['', Validators.required],
            'username': ['', Validators.required],
            'password': ['', Validators.required]
        });
    }

    submit() {
        this.dataService.signup(this.signupForm.controls.username.value, this.signupForm.controls.password.value, this.signupForm.controls.email.value).then(function (result) {
            if(result.status == 200) {
                var user = result.json();
                this.app.login(user);
                this.location.back();
            } else {
                this.message = result.text();
            }
        }.bind(this), function(err) {
            this.message = 'An error occurred: ' + JSON.stringify(err);
        }.bind(this));
    }
}
