import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { environment } from '../../../enviroments/enviroment.develop';

@Component({
  selector: 'app-reporte',
  standalone: true,
  template: `<button class="btn btn-primary" (click)="downloadReport()">Generar Reporte</button>`,
  styleUrls: ['./reporte-miembros.component.css']
})
export class ReporteComponent {
  private reporteUrl = environment.reporteUrl;
  constructor(private http: HttpClient) {}

  downloadReport() {
    this.http.get(this.reporteUrl, { responseType: 'text' })
      .subscribe((data) => {
        const blob = this.base64ToBlob(data, 'application/pdf');
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'reporte.pdf';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
      });
  }

  private base64ToBlob(base64: string, type: string) {
    const byteCharacters = atob(base64);
    const byteNumbers = new Array(byteCharacters.length);
    for (let i = 0; i < byteCharacters.length; i++) {
      byteNumbers[i] = byteCharacters.charCodeAt(i);
    }
    const byteArray = new Uint8Array(byteNumbers);
    return new Blob([byteArray], { type });
  }
}
