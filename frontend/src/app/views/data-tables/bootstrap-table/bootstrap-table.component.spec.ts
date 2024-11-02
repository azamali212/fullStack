import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BootstrapTableComponent } from './bootstrap-table.component';

describe('BootstrapTableComponent', () => {
  let component: BootstrapTableComponent;
  let fixture: ComponentFixture<BootstrapTableComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BootstrapTableComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BootstrapTableComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
