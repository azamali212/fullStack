import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { ButtonComponent } from './shared/components/button/button.component';
import { InputComponent } from './shared/components/input/input.component';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet,ButtonComponent,InputComponent],
  templateUrl: './app.component.html',
  styleUrls:['./app.component.css'],
})
export class AppComponent {
  title = 'frontend';
}
