import { NgModule } from '@angular/core';
import { SearchComponent } from './search.component';
import { NgxPaginationModule } from 'ngx-pagination';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { NgScrollbarModule } from 'ngx-scrollbar';

@NgModule({
    imports: [
        CommonModule,
        NgScrollbarModule,
        ReactiveFormsModule,
        NgxPaginationModule,
    ],
    declarations: [SearchComponent],
    exports: [SearchComponent]
})
export class SearchModule {

}
