import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { NgxPaginationModule } from 'ngx-pagination';
import { DecimalPipe, AsyncPipe } from '@angular/common';
import { NgbHighlight, NgbPaginationModule } from '@ng-bootstrap/ng-bootstrap';
import { NgbdSortableHeader } from '../../shared/directives/sortable.directive';

import { DataTablesRoutingModule } from './data-tables-routing.module';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { ListPaginationComponent } from './list-pagination/list-pagination.component';
import { BootstrapTableComponent } from './bootstrap-table/bootstrap-table.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    NgxPaginationModule,
    NgbModule,
    DecimalPipe,
    FormsModule, 
    AsyncPipe, 
    NgbHighlight, 
    NgbdSortableHeader, 
    NgbPaginationModule,
    DataTablesRoutingModule
  ],
  declarations: [ListPaginationComponent, BootstrapTableComponent]
})
export class DataTablesModule { }
