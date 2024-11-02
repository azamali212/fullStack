import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { FormsRoutingModule } from './forms-routing.module';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';

import { BasicFormComponent } from './basic-form/basic-form.component';
import { AppImgCropperComponent } from './img-cropper/img-cropper.component';
// import { ImageCropperModule } from 'ngx-img-cropper';
import { WizardComponent } from './wizard/wizard.component';
import { SharedComponentsModule } from 'src/app/shared/components/shared-components.module';
import { FormWizardModule } from 'src/app/shared/components/form-wizard/form-wizard.module';
// import { TextMaskModule } from 'angular2-text-mask';
import { InputMaskComponent } from './input-mask/input-mask.component';
import { InputGroupsComponent } from './input-groups/input-groups.component';
import { FormLayoutsComponent } from './form-layouts/form-layouts.component';
import { NgxMaskDirective, NgxMaskPipe, provideNgxMask } from 'ngx-mask';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    SharedComponentsModule,
    NgbModule,
    // ImageCropperModule,
    // TextMaskModule,
    NgxMaskDirective, 
    NgxMaskPipe,
    FormWizardModule,
    FormsRoutingModule
  ],
  providers: [provideNgxMask()],
  declarations: [BasicFormComponent, AppImgCropperComponent, WizardComponent, InputMaskComponent, InputGroupsComponent, FormLayoutsComponent]
})
export class AppFormsModule { }
