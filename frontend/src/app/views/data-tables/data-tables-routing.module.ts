import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { ListPaginationComponent } from './list-pagination/list-pagination.component';
import { BootstrapTableComponent } from './bootstrap-table/bootstrap-table.component';

const routes: Routes = [
  {
    path: 'list',
    component: ListPaginationComponent
  },
  {
    path: 'bootstrap-table',
    component: BootstrapTableComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class DataTablesRoutingModule { }
