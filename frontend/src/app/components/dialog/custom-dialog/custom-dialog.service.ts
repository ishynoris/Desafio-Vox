import { Component, inject, Injectable, input, Input } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MAT_DIALOG_DATA, MatDialog, MatDialogModule, MatDialogRef } from '@angular/material/dialog';
import { MatFormFieldModule } from '@angular/material/form-field';
import { Observable } from 'rxjs';


interface DialogData {
	title?: string
}

@Injectable({
	providedIn: 'root'
})
export class CustomDialogService {
	
	dialog = inject(MatDialog);

	onOpen(data?: DialogData): Observable<boolean> {
		return this.dialog
			.open(CustomDialogComponent, {
				data: data,
				width: "500px",
			})
			.afterClosed();
	}
}

@Component({
	selector: 'app-apagar-empresa',
	standalone: true,
	imports: [ MatDialogModule, MatFormFieldModule, MatButtonModule ],
	template: `
		<h2 mat-dialog-title>Confirmação</h2>
		<mat-dialog-content>
			<p>Deseja realmente apagar?</p>
			<p>{{ this.data.title }}</p>
		</mat-dialog-content>
		<mat-dialog-actions>
			<button mat-button (click)="onNao()">Não</button>
			<button mat-button (click)="onSim()" cdkFocusInitial>Sim</button>
		</mat-dialog-actions>
	`
})
export class CustomDialogComponent {
	readonly dialogRef = inject(MatDialogRef<CustomDialogComponent, boolean>);
	readonly data = inject<DialogData>(MAT_DIALOG_DATA);
	
	onSim() {
		this.dialogRef.close(true);
	}

	onNao() {
		this.dialogRef.close(false);
	}
}