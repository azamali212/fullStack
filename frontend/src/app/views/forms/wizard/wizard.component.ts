import { Component, OnInit } from '@angular/core';
import { UntypedFormGroup, UntypedFormBuilder } from '@angular/forms';

@Component({
  selector: 'app-wizard',
  templateUrl: './wizard.component.html',
  styleUrls: ['./wizard.component.scss']
})
export class WizardComponent implements OnInit {
  isCompleted: boolean;
  data: any = {
    email: ''
  };
  step2Form: UntypedFormGroup;

  constructor(
    private fb: UntypedFormBuilder
  ) { }

  ngOnInit() {
    this.step2Form = this.fb.group({
      experience: [2]
    });
  }

  onStep1Next(e) {}
  onStep2Next(e) {}
  onStep3Next(e) {}
  onComplete(e) {}
}
