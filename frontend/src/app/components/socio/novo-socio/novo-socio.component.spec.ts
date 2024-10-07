import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NovoSocioComponent } from './novo-socio.component';

describe('NovoSocioComponent', () => {
  let component: NovoSocioComponent;
  let fixture: ComponentFixture<NovoSocioComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [NovoSocioComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(NovoSocioComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
