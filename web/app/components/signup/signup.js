import {
    ComponentMetadata as Component,
    ViewMetadata as View
} from 'angular2/angular2';
import { Location } from 'angular2/router';
import { Http } from 'http/http';
import {
    FormBuilder,
    Validators,
    FORM_DIRECTIVES,
    ControlGroup,
    forms
} from 'angular2/forms';
import { host } from 'app/services/dataService';
import { App } from 'app/components/app/app';

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
    message;
    constructor(app: App, location: Location, builder: FormBuilder, http: Http) {
        this.app = app;
        this.http = http;
        this.location = location;
        this.message = '';
        this.signupForm = builder.group({
            'email':    ['', Validators.required],
            'username': ['', Validators.required],
            'password': ['', Validators.required]
        });
    }

    signup(username, password, email) {
        return this.http.post(host + '/api/signup', 'username=' + username + '&password=' + password + '&email=' + email, {headers: {
            'Content-type': 'application/x-www-form-urlencoded'
        }})
            .toRx()
            .toPromise();
    }

    submit() {
        this.signup(this.signupForm.controls.username.value, this.signupForm.controls.password.value, this.signupForm.controls.email.value).then(function (ret) {
            if(ret.status == 200) {
                var user = ret.json();
                this.app.login(user);
                this.location.back();
            } else {
                this.message = ret.text();
            }
        }.bind(this), function(err) {
            this.message = 'An error occurred: ' + JSON.stringify(err);
        }.bind(this));
    }
}
