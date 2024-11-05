import { Component,Input } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-input',
  standalone: true,
  imports: [InputComponent,CommonModule],
  templateUrl: './input.component.html',
  styleUrl: './input.component.css'
})
export class InputComponent {
  @Input() id!: string;
  @Input() name!: string;
  @Input() type: string = 'text';
  @Input() label!: string;
  @Input() autocomplete: string = '';
  @Input() required: boolean = false;
  @Input() class: string = '';  // Required attribute
}
