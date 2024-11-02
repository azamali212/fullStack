import { Component, OnInit } from '@angular/core';
import { CalendarEvent } from 'angular-calendar';
import { UntypedFormGroup, UntypedFormBuilder, UntypedFormControl, Validators } from '@angular/forms';
import { CalendarAppEvent } from 'src/app/shared/models/calendar-event.model';
import { NgbActiveModal } from '@ng-bootstrap/ng-bootstrap';
import { Utils } from 'src/app/shared/utils';

interface DialogData {
  event?: CalendarEvent;
  action?: string;
  date?: Date;
}
@Component({
  selector: 'app-calendar-form-dialog',
  templateUrl: './calendar-form-dialog.component.html',
  styleUrls: ['./calendar-form-dialog.component.scss']
})
export class CalendarFormDialogComponent implements OnInit {
  data: DialogData;
  event: CalendarEvent;
  dialogTitle: string;
  eventForm: UntypedFormGroup;
  action: string;
  constructor(
    public activeModal: NgbActiveModal,
    private formBuilder: UntypedFormBuilder
  ) { }

  ngOnInit() {
    setTimeout(() => {
      if (this.action === 'edit') {
        this.dialogTitle = this.event.title;
      } else {
        this.dialogTitle = 'Add Event';
        this.event = new CalendarAppEvent(this.data.event);
      }
      this.eventForm = this.buildEventForm(this.event);

    }, 100);
    this.eventForm = this.buildEventForm(this.event);

  }
  buildEventForm(event: CalendarAppEvent = {start: null, title: null, color: {primary: '', secondary: ''}, meta: {location: '', notes: ''}}) {
    return new UntypedFormGroup({
      _id: new UntypedFormControl(event._id),
      title: new UntypedFormControl(event.title, Validators.required),
      start: new UntypedFormControl(Utils.dateToNgbDate(event.start), Validators.required),
      end: new UntypedFormControl(Utils.dateToNgbDate(event.end)),
      allDay: new UntypedFormControl(event.allDay),
      color: this.formBuilder.group({
        primary: new UntypedFormControl(event.color.primary),
        secondary: new UntypedFormControl(event.color.secondary)
      }),
      meta: this.formBuilder.group({
        location: new UntypedFormControl(event.meta.location),
        notes: new UntypedFormControl(event.meta.notes)
      })
    });
  }

}
