package frontEnd

import (
	"fmt"
	"log"
	"myDocker/pkg"
	"os"
)

func CreateFile() (string, error) {
	output := ".env"

	data := fmt.Sprintf(
		"API_URL=http://%s:8000/api/v1\nAPI_CNPJ_URL=https://open.cnpja.com/office/\nAPI_CEP=https://viacep.com.br/ws/\n",
		pkg.GetLocalIP(),
	)

	if err := os.WriteFile(output, []byte(data), 0644); err != nil {
		log.Printf("Erro: %s", err)
		return "", err
	}

	return output, nil
}
