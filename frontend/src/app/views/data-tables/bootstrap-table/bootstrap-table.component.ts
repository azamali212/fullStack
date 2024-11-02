import { AsyncPipe, DecimalPipe } from '@angular/common';
import { Component, QueryList, ViewChildren } from '@angular/core';
import { Observable } from 'rxjs';

import { Country } from '../../../shared/models/country.model';
import { CountryService } from '../../../shared/services/country.service';
import { NgbdSortableHeader, SortEvent } from '../../../shared/directives/sortable.directive';
import { FormsModule } from '@angular/forms';
import { NgbHighlight, NgbPaginationModule } from '@ng-bootstrap/ng-bootstrap';





@Component({
  selector: 'app-bootstrap-table',
  standalone: false,
  templateUrl: './bootstrap-table.component.html',
  styleUrl: './bootstrap-table.component.scss',
  providers: [CountryService, DecimalPipe],

})
export class BootstrapTableComponent {
  countries$: Observable<Country[]>;
  total$: Observable<number>;

  @ViewChildren(NgbdSortableHeader) headers: QueryList<NgbdSortableHeader>;

  constructor(public service: CountryService) {
    this.countries$ = service.countries$;
    this.total$ = service.total$;
  }

  onSort({ column, direction }: SortEvent) {
    // resetting other headers
    this.headers.forEach((header) => {
      if (header.sortable !== column) {
        header.direction = '';
      }
    });

    this.service.sortColumn = column;
    this.service.sortDirection = direction;
  }
}
