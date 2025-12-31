package createlist

import (
	"CnaeApi/internal/schema"
	"log"
	"net/http"

	"github.com/gin-gonic/gin"
	"github.com/thedatashed/xlsxreader"
)

var dataRows []schema.CNAESchema

func ReadList() {
	xl, err := xlsxreader.OpenFile("internal/files/CnaeList.xlsx")

	if err != nil {
		log.Println("Erro ao abrir o arquivo:", err)
	}

	firstRow := true

	defer xl.Close()

	for row := range xl.ReadRows(xl.Sheets[0]) {
		//row.Cells[0] = 'CNAE'
		//row.Cells[1] = 'Descrição'
		//row.Cells[2] = 'Anexo'

		if firstRow {
			firstRow = false
			continue
		}

		if len(row.Cells) < 3 {
			continue
		}

		data := schema.CNAESchema{
			CNAE: row.Cells[0].Value, Description: row.Cells[1].Value, Attachment: row.Cells[2].Value,
		}

		dataRows = append(dataRows, data)

		log.Println("-- Cnaes carregados --")
	}
}

func GetCnaes(c *gin.Context) {
	c.JSON(http.StatusOK, dataRows)
}
