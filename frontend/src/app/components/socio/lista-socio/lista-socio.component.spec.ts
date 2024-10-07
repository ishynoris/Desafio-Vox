import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListaSocioComponent } from './lista-socio.component';

describe('ListaSocioComponent', () => {
  let component: ListaSocioComponent;
  let fixture: ComponentFixture<ListaSocioComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ListaSocioComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ListaSocioComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
