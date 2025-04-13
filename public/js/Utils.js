export class Utils {
    static formatDateTimeString(dateString) {
        const dateObj = new Date(dateString);
        
        // Formatear fecha como dd/mm/yyyy
        const day = dateObj.getDate().toString().padStart(2, '0');
        const month = (dateObj.getMonth() + 1).toString().padStart(2, '0'); // getMonth() devuelve 0-11
        const year = dateObj.getFullYear();
        const formattedDate = `${day}/${month}/${year}`;
        
        // Formatear hora como hh:mm AM/PM
        let hours = dateObj.getHours();
        const minutes = dateObj.getMinutes().toString().padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // las 0 horas deben ser 12 en formato AM/PM
        const formattedTime = `${hours}:${minutes} ${ampm}`;

        return {date: formattedDate, time: formattedTime};
    }
}