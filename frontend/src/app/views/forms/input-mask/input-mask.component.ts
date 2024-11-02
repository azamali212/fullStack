import { Component, OnInit } from '@angular/core';
import { UntypedFormBuilder, UntypedFormGroup } from '@angular/forms';

@Component({
    selector: 'app-input-mask',
    templateUrl: './input-mask.component.html',
    styleUrls: ['./input-mask.component.scss']
})
export class InputMaskComponent implements OnInit {
    formMask: UntypedFormGroup;

    constructor(private fb: UntypedFormBuilder) { }

    ngOnInit() {
        this.formMask = this.fb.group({
            
        });
    }
    submit() {
        console.log(this.formMask.value);
    }

}
