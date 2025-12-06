package frontEnd

import (
	"fmt"
	"log"
	"myDocker/pkg"
	"os"
)

func CreateFile() (string, error) {
	output := ".env"
	data := []byte(fmt.Sprintf("API_URL=http://%s:8000/api/v1", pkg.GetLocalIP()))

	if err := os.WriteFile(output, data, 0644); err != nil {
		log.Printf("Erro: %s", err)
		return "", err
	}

	return output, nil
}
